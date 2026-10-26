<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $filters = $request->validate([
            'mulai' => 'nullable|date',
            'sampai' => 'nullable|date|after_or_equal:mulai',
            'status' => 'nullable|in:dipinjam,dikembalikan,terlambat',
        ]);

        $query = Transaksi::with(['anggota', 'buku'])->latest('tanggal_pinjam');

        if (!empty($filters['mulai'])) {
            $query->whereDate('tanggal_pinjam', '>=', $filters['mulai']);
        }

        if (!empty($filters['sampai'])) {
            $query->whereDate('tanggal_pinjam', '<=', $filters['sampai']);
        }

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        $transaksi = $query->get();
        $ringkasan = [
            'total' => $transaksi->count(),
            'dipinjam' => $transaksi->where('status', 'dipinjam')->count(),
            'dikembalikan' => $transaksi->where('status', 'dikembalikan')->count(),
            'terlambat' => $transaksi->where('status', 'terlambat')->count(),
            'denda' => $transaksi->sum('denda'),
        ];

        return view('report.index', compact('transaksi', 'ringkasan', 'filters'));
    }
}