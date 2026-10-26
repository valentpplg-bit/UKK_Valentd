<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\Buku;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransaksiController extends Controller
{
    public function index()
    {
        $transaksi = Transaksi::with(['anggota', 'buku'])->latest()->get();

        return view('transaksi.index', compact('transaksi'));
    }

    public function create()
    {
        $anggota = Anggota::orderBy('nama_lengkap')->get();
        $buku = Buku::where('stok', '>', 0)->orderBy('judul_buku')->get();

        return view('transaksi.create', compact('anggota', 'buku'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'id_anggota' => 'required|exists:anggota,id_anggota',
            'id_buku' => 'required|exists:buku,id_buku',
            'tanggal_pinjam' => 'required|date',
            'status' => 'required|in:dipinjam,dikembalikan,terlambat',
            'denda' => 'nullable|numeric|min:0',
        ]);

        $activeLoan = Transaksi::where('id_anggota', $data['id_anggota'])
            ->where('id_buku', $data['id_buku'])
            ->where('status', 'dipinjam')
            ->exists();

        if ($activeLoan && $data['status'] !== 'dikembalikan') {
            return back()->withInput()->withErrors([
                'id_buku' => 'Anggota tersebut masih meminjam buku ini.',
            ]);
        }

        DB::transaction(function () use ($data) {
            $buku = Buku::whereKey($data['id_buku'])->lockForUpdate()->firstOrFail();

            if ($buku->stok < 1) {
                abort(422, 'Stok buku sedang habis.');
            }

            $tanggalPinjam = \Carbon\Carbon::parse($data['tanggal_pinjam']);
            $status = $data['status'];

            if ($status !== 'dikembalikan') {
                $buku->decrement('stok');
            }

            Transaksi::create([
                'id_anggota' => $data['id_anggota'],
                'id_buku' => $data['id_buku'],
                'tanggal_pinjam' => $data['tanggal_pinjam'],
                'tanggal_jatuh_tempo' => $tanggalPinjam->copy()->addDays(config('perpustakaan.lama_peminjaman_hari')),
                'tanggal_kembali' => $status === 'dikembalikan' ? now()->startOfDay() : null,
                'status' => $status,
                'denda' => $data['denda'] ?? 0,
            ]);
        });

        return redirect()->route('transaksi.index')
            ->with('success', 'Transaksi peminjaman berhasil ditambahkan.');
    }

    public function edit(Transaksi $transaksi)
    {
        $anggota = Anggota::orderBy('nama_lengkap')->get();
        $buku = Buku::orderBy('judul_buku')->get();

        return view('transaksi.edit', compact('transaksi', 'anggota', 'buku'));
    }

    public function update(Request $request, Transaksi $transaksi)
    {
        $data = $request->validate([
            'id_anggota' => 'required|exists:anggota,id_anggota',
            'id_buku' => 'required|exists:buku,id_buku',
            'tanggal_pinjam' => 'required|date',
            'status' => 'required|in:dipinjam,dikembalikan,terlambat',
            'denda' => 'nullable|numeric|min:0',
        ]);

        if ($transaksi->status !== 'dipinjam' && $data['id_buku'] != $transaksi->id_buku) {
            return back()->withInput()->withErrors([
                'id_buku' => 'Buku pada transaksi yang sudah selesai tidak dapat diganti.',
            ]);
        }

        DB::transaction(function () use ($data, $transaksi) {
            $statusLama = $transaksi->status;

            if ($transaksi->status === 'dipinjam'
                && $data['status'] !== 'dikembalikan'
                && $data['id_buku'] != $transaksi->id_buku) {
                $bukuBaru = Buku::whereKey($data['id_buku'])->lockForUpdate()->firstOrFail();

                if ($bukuBaru->stok < 1) {
                    abort(422, 'Stok buku baru sedang habis.');
                }

                Buku::whereKey($transaksi->id_buku)->increment('stok');
                $bukuBaru->decrement('stok');
            }

            $tanggalPinjam = \Carbon\Carbon::parse($data['tanggal_pinjam']);
            $tanggalJatuhTempo = $tanggalPinjam->copy()->addDays(config('perpustakaan.lama_peminjaman_hari'));
            $tanggalKembali = $data['status'] === 'dikembalikan' ? ($transaksi->tanggal_kembali ?? now()->startOfDay()) : null;
            $hariTerlambat = $tanggalKembali && $tanggalKembali->greaterThan($tanggalJatuhTempo)
                ? $tanggalJatuhTempo->diffInDays($tanggalKembali)
                : ($data['status'] === 'terlambat' && now()->startOfDay()->greaterThan($tanggalJatuhTempo)
                    ? $tanggalJatuhTempo->diffInDays(now()->startOfDay())
                    : 0);
            $denda = $data['denda'] ?? ($hariTerlambat * config('perpustakaan.denda_per_hari'));

            if ($statusLama === 'dipinjam' && $data['status'] === 'dikembalikan') {
                Buku::whereKey($transaksi->id_buku)->increment('stok');
            } elseif ($statusLama !== 'dipinjam' && $data['status'] === 'dipinjam') {
                $buku = Buku::whereKey($data['id_buku'])->lockForUpdate()->firstOrFail();
                if ($buku->stok < 1) {
                    abort(422, 'Stok buku sedang habis.');
                }
                $buku->decrement('stok');
            }

            $transaksi->update([
                'id_anggota' => $data['id_anggota'],
                'id_buku' => $data['id_buku'],
                'tanggal_pinjam' => $data['tanggal_pinjam'],
                'tanggal_jatuh_tempo' => $tanggalJatuhTempo,
                'tanggal_kembali' => $tanggalKembali,
                'status' => $data['status'],
                'denda' => $denda,
            ]);
        });

        return redirect()->route('transaksi.index')
            ->with('success', 'Transaksi berhasil diubah.');
    }

    public function destroy(Transaksi $transaksi)
    {
        DB::transaction(function () use ($transaksi) {
            if ($transaksi->status === 'dipinjam') {
                Buku::whereKey($transaksi->id_buku)->increment('stok');
            }

            $transaksi->delete();
        });

        return redirect()->route('transaksi.index')
            ->with('success', 'Transaksi berhasil dihapus.');
    }

    public function returnBook(Transaksi $transaksi)
    {
        if ($transaksi->status !== 'dipinjam') {
            return back()->with('error', 'Transaksi ini sudah dikembalikan.');
        }

        DB::transaction(function () use ($transaksi) {
            $tanggalKembali = now()->startOfDay();
            $tanggalJatuhTempo = $transaksi->tanggal_jatuh_tempo
                ?? $transaksi->tanggal_pinjam->copy()->addDays(config('perpustakaan.lama_peminjaman_hari'));
            $hariTerlambat = $tanggalKembali->greaterThan($tanggalJatuhTempo)
                ? $tanggalJatuhTempo->diffInDays($tanggalKembali)
                : 0;

            $transaksi->update([
                'tanggal_kembali' => $tanggalKembali,
                'status' => $hariTerlambat > 0 ? 'terlambat' : 'dikembalikan',
                'denda' => $hariTerlambat * config('perpustakaan.denda_per_hari'),
            ]);

            Buku::whereKey($transaksi->id_buku)->increment('stok');
        });

        return redirect()->route('transaksi.index')
            ->with('success', 'Buku berhasil dikembalikan.');
    }
}