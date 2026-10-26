<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\Buku;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function dashboard(Request $request)
    {
        $anggota = $request->user()->anggota;
        $loans = $this->userTransactions($anggota);
        $activeLoans = (clone $loans)->where('status', 'dipinjam')->with('buku')->latest()->get();
        $recentBooks = Buku::latest()->take(6)->get();

        return view('user.dashboard', [
            'anggota' => $anggota,
            'activeLoans' => $activeLoans,
            'recentBooks' => $recentBooks,
            'borrowedCount' => (clone $loans)->where('status', 'dipinjam')->count(),
            'totalCount' => (clone $loans)->count(),
            'returnedCount' => (clone $loans)->whereIn('status', ['dikembalikan', 'terlambat'])->count(),
        ]);
    }

    public function catalog(Request $request)
    {
        $search = trim((string) $request->query('q'));
        $books = Buku::when($search, function ($query) use ($search) {
            $query->where(function ($query) use ($search) {
                $query->where('judul_buku', 'like', "%{$search}%")
                    ->orWhere('penulis', 'like', "%{$search}%")
                    ->orWhere('kategori', 'like', "%{$search}%");
            });
        })->latest()->paginate(12)->withQueryString();

        return view('user.catalog', compact('books', 'search'));
    }

    public function showBook(Buku $buku)
    {
        return view('user.book-show', compact('buku'));
    }

    public function borrow(Request $request, Buku $buku)
    {
        $anggota = $request->user()->anggota;
        if (!$anggota) {
            return redirect()->route('user.profile.edit')->with('error', 'Lengkapi profil anggota sebelum meminjam buku.');
        }

        $alreadyBorrowed = Transaksi::where('id_anggota', $anggota->id_anggota)
            ->where('id_buku', $buku->id_buku)->where('status', 'dipinjam')->exists();
        if ($alreadyBorrowed) {
            return back()->with('error', 'Buku ini masih tercatat sedang Anda pinjam.');
        }

        DB::transaction(function () use ($anggota, $buku) {
            $lockedBook = Buku::whereKey($buku->id_buku)->lockForUpdate()->firstOrFail();
            if ($lockedBook->stok < 1) {
                abort(422, 'Buku sedang tidak tersedia.');
            }

            $lockedBook->decrement('stok');
            $tanggalPinjam = now()->startOfDay();
            Transaksi::create([
                'id_anggota' => $anggota->id_anggota,
                'id_buku' => $lockedBook->id_buku,
                'tanggal_pinjam' => $tanggalPinjam,
                'tanggal_jatuh_tempo' => $tanggalPinjam->copy()->addDays(config('perpustakaan.lama_peminjaman_hari')),
                'status' => 'dipinjam',
                'denda' => 0,
            ]);
        });

        return redirect()->route('user.loans')->with('success', 'Berhasil meminjam buku.');
    }

    public function loans(Request $request)
    {
        $loans = $this->userTransactions($request->user()->anggota)->with('buku')->latest()->paginate(10);

        return view('user.loans', compact('loans'));
    }

    public function returns(Request $request)
    {
        $returns = $this->userTransactions($request->user()->anggota)
            ->with('buku')
            ->whereIn('status', ['dikembalikan', 'terlambat'])
            ->latest()
            ->paginate(10);

        return view('user.returns', compact('returns'));
    }

    public function history(Request $request)
    {
        $history = $this->userTransactions($request->user()->anggota)
            ->with('buku')
            ->latest()
            ->paginate(10);

        return view('user.history', compact('history'));
    }

    public function returnBook(Request $request, Transaksi $transaksi)
    {
        $this->ownedTransaction($request, $transaksi);
        if ($transaksi->status !== 'dipinjam') {
            return back()->with('error', 'Buku ini sudah dikembalikan.');
        }

        DB::transaction(function () use ($transaksi) {
            $returnedAt = now()->startOfDay();
            $deadline = $transaksi->tanggal_jatuh_tempo
                ?? $transaksi->tanggal_pinjam->copy()->addDays(config('perpustakaan.lama_peminjaman_hari'));
            $lateDays = $returnedAt->greaterThan($deadline) ? $deadline->diffInDays($returnedAt) : 0;
            $transaksi->update([
                'tanggal_kembali' => $returnedAt,
                'status' => $lateDays > 0 ? 'terlambat' : 'dikembalikan',
                'denda' => $lateDays * config('perpustakaan.denda_per_hari'),
            ]);
            Buku::whereKey($transaksi->id_buku)->increment('stok');
        });

        return back()->with('success', 'Buku berhasil dikembalikan.');
    }

    public function profile(Request $request)
    {
        return view('user.profile', ['user' => $request->user(), 'anggota' => $request->user()->anggota]);
    }

    public function editProfile(Request $request)
    {
        return view('user.profile-edit', ['user' => $request->user(), 'anggota' => $request->user()->anggota]);
    }

    public function updateProfile(Request $request)
    {
        $anggota = $request->user()->anggota;
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $request->user()->id,
            'password' => 'nullable|string|min:8|confirmed',
            'nis' => 'required|string|max:50|unique:anggota,nis,' . ($anggota?->id_anggota) . ',id_anggota',
            'alamat' => 'nullable|string|max:255',
            'kelas' => 'nullable|string|max:100',
        ]);

        $userData = ['name' => $data['name'], 'email' => $data['email']];
        if (!empty($data['password'])) {
            $userData['password'] = $data['password'];
        }

        $request->user()->update($userData);
        Anggota::updateOrCreate(
            ['id_user' => $request->user()->id],
            ['nis' => $data['nis'], 'nama_lengkap' => $data['name'], 'alamat' => $data['alamat'] ?? null, 'kelas' => $data['kelas'] ?? null]
        );

        return redirect()->route('user.profile')->with('success', 'Profil berhasil diperbarui.');
    }

    private function userTransactions(?Anggota $anggota)
    {
        return Transaksi::where('id_anggota', $anggota?->id_anggota);
    }

    private function ownedTransaction(Request $request, Transaksi $transaksi): void
    {
        abort_unless($transaksi->id_anggota === $request->user()->anggota?->id_anggota, 403);
    }
}