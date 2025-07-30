<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\Investasi;
use App\Models\Sedekah;
use Carbon\Carbon;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $month = $request->get('month', Carbon::now()->month);
        $year = $request->get('year', Carbon::now()->year);

        // Get statistics for all users (public data)
        $pendapatan = Transaksi::where('kategori', 'pendapatan')
            ->whereMonth('tanggal', $month)
            ->whereYear('tanggal', $year)
            ->sum('jumlah');

        $pengeluaran = Transaksi::where('kategori', 'pengeluaran')
            ->whereMonth('tanggal', $month)
            ->whereYear('tanggal', $year)
            ->sum('jumlah');

        $investasi = Investasi::whereMonth('tanggal', $month)
            ->whereYear('tanggal', $year)
            ->sum('jumlah');

        $sedekah = Sedekah::whereMonth('tanggal', $month)
            ->whereYear('tanggal', $year)
            ->sum('jumlah');

        // Chart data
        $chartData = [
            'labels' => ['Pendapatan', 'Pengeluaran', 'Investasi', 'Sedekah'],
            'data' => [$pendapatan, $pengeluaran, $investasi, $sedekah],
            'colors' => ['#28a745', '#dc3545', '#ffc107', '#17a2b8']
        ];

        // Monthly data for line chart
        $monthlyData = [];
        for ($i = 1; $i <= 12; $i++) {
            $monthlyData['pendapatan'][] = Transaksi::where('kategori', 'pendapatan')
                ->whereMonth('tanggal', $i)
                ->whereYear('tanggal', $year)
                ->sum('jumlah');

            $monthlyData['pengeluaran'][] = Transaksi::where('kategori', 'pengeluaran')
                ->whereMonth('tanggal', $i)
                ->whereYear('tanggal', $year)
                ->sum('jumlah');
        }

        return view('home', compact('pendapatan', 'pengeluaran', 'investasi', 'sedekah', 'chartData', 'monthlyData', 'month', 'year'));
    }
}
