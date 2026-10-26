<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AnggotaController extends Controller
{
    public function index()
    {
        $anggota = Anggota::with('user')->latest()->get();
        return view('anggota.index', compact('anggota'));
    }

    public function create()
    {
        return view('anggota.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'nis' => 'required|unique:anggota,nis',
            'nama_lengkap' => 'required|string|max:255',
            'alamat' => 'nullable|string|max:255',
            'kelas' => 'nullable|string|max:100',
        ]);

        DB::transaction(function () use ($data) {
            $user = User::create([
                'name' => $data['nama_lengkap'],
                'email' => $data['email'],
                'password' => $data['password'],
                'role' => 'anggota',
                'status' => 'aktif',
            ]);

            Anggota::create([
                'id_user' => $user->id,
                'nis' => $data['nis'],
                'nama_lengkap' => $data['nama_lengkap'],
                'alamat' => $data['alamat'] ?? null,
                'kelas' => $data['kelas'] ?? null,
            ]);
        });

        return redirect()
            ->route('anggota.index')
            ->with('success', 'Data anggota berhasil ditambahkan.');
    }

    public function edit($id_anggota)
    {
        $anggota = Anggota::with('user')->findOrFail($id_anggota);
        return view('anggota.edit', compact('anggota'));
    }

    public function update(Request $request, $id_anggota)
    {
        $anggota = Anggota::with('user')->findOrFail($id_anggota);

        $data = $request->validate([
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($anggota->user?->id),
            ],
            'password' => 'nullable|string|min:8|confirmed',
            // Gunakan Rule::unique untuk mengabaikan record yang sedang diupdate
            'nis' => [
                'required',
                Rule::unique('anggota', 'nis')->ignore($anggota->getKey(), $anggota->getKeyName()),
            ],
            'nama_lengkap' => 'required',
            'alamat' => 'nullable',
            'kelas' => 'nullable',
        ]);

        DB::transaction(function () use ($anggota, $data) {
            $anggota->update([
                'nis' => $data['nis'],
                'nama_lengkap' => $data['nama_lengkap'],
                'alamat' => $data['alamat'] ?? null,
                'kelas' => $data['kelas'] ?? null,
            ]);

            if ($anggota->user) {
                $userData = [
                    'name' => $data['nama_lengkap'],
                    'email' => $data['email'],
                ];

                if (!empty($data['password'])) {
                    $userData['password'] = $data['password'];
                }

                $anggota->user->update($userData);
            }
        });

        return redirect()
            ->route('anggota.index')
            ->with('success', 'Data anggota berhasil diubah.');
    }

    public function destroy($id_anggota)
    {
        $anggota = Anggota::findOrFail($id_anggota);
        $anggota->delete();

        return redirect()
            ->route('anggota.index')
            ->with('success', 'Data anggota berhasil dihapus.');
    }
}