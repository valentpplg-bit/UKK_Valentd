<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BukuController extends Controller
{
    // Menampilkan daftar buku
    public function index()
    {
        $buku = Buku::latest()->get();

        return view('buku.index', compact('buku'));
    }

    // Menampilkan form tambah buku
    public function create()
    {
        return view('buku.create');
    }

    // Menyimpan data buku
    public function store(Request $request)
    {
        $request->validate([
            'judul_buku' => 'required',
            'penulis'    => 'required',
            'penerbit'   => 'required',
            'tahun'      => 'required',
            'kategori'   => 'nullable',
            'deskripsi'  => 'nullable',
            'stok'       => 'required|integer|min:0',
            'gambar'     => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $gambarPath = null;

        if ($request->hasFile('gambar')) {
            $gambarPath = $request->file('gambar')->store('buku', 'public');
        }

        Buku::create([
            'judul_buku' => $request->judul_buku,
            'penulis'    => $request->penulis,
            'penerbit'   => $request->penerbit,
            'tahun'      => $request->tahun,
            'kategori'   => $request->kategori,
            'deskripsi'  => $request->deskripsi,
            'stok'       => $request->stok,
            'gambar'     => $gambarPath,
        ]);

        return redirect()->route('buku.index')
                         ->with('success', 'Data buku berhasil ditambahkan.');
    }

    // Menampilkan form edit
    public function edit($id_buku)
    {
        $buku = Buku::findOrFail($id_buku);

        return view('buku.edit', compact('buku'));
    }

    // Mengupdate data buku
    public function update(Request $request, $id_buku)
    {
        $request->validate([
            'judul_buku' => 'required',
            'penulis'    => 'required',
            'penerbit'   => 'required',
            'tahun'      => 'required',
            'kategori'   => 'nullable',
            'deskripsi'  => 'nullable',
            'stok'       => 'required|integer|min:0',
            'gambar'     => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $buku = Buku::findOrFail($id_buku);

        $gambarPath = $buku->gambar;

        if ($request->hasFile('gambar')) {
            if ($buku->gambar && Storage::disk('public')->exists($buku->gambar)) {
                Storage::disk('public')->delete($buku->gambar);
            }

            $gambarPath = $request->file('gambar')->store('buku', 'public');
        }

        $buku->update([
            'judul_buku' => $request->judul_buku,
            'penulis'    => $request->penulis,
            'penerbit'   => $request->penerbit,
            'tahun'      => $request->tahun,
            'kategori'   => $request->kategori,
            'deskripsi'  => $request->deskripsi,
            'stok'       => $request->stok,
            'gambar'     => $gambarPath,
        ]);

        return redirect()->route('buku.index')
                         ->with('success', 'Data buku berhasil diubah.');
    }

    // Menghapus data buku
    public function destroy($id_buku)
    {
        $buku = Buku::findOrFail($id_buku);

        $buku->delete();

        return redirect()->route('buku.index')
                         ->with('success', 'Data buku berhasil dihapus.');
    }
}