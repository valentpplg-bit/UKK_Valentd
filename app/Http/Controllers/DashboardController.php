<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\Buku;
use App\Models\Transaksi;

class DashboardController extends Controller
{
    public function index()
    {
        $totalBuku = Buku::count();
        $totalAnggota = Anggota::count();
        $totalPeminjaman = Transaksi::where('status', 'dipinjam')->count();
        $totalTransaksi = Transaksi::count();
        $transaksiTerbaru = Transaksi::with(['anggota', 'buku'])
            ->latest('tanggal_pinjam')
            ->latest('id_transaksi')
            ->take(5)
            ->get();

        return view('dashboard.index', compact(
            'totalBuku',
            'totalAnggota',
            'totalPeminjaman',
            'totalTransaksi',
            'transaksiTerbaru'
        ));
    }
}