<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Donasi;
use App\Models\Berita;
use App\Models\Perizinan;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_users' => User::count(),
            'donasi_bulan_ini' => Donasi::success()
                ->whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->sum('nominal'),
            'berita_published' => Berita::published()->count(),
            'perizinan_pending' => Perizinan::pending()->count(),
        ];

        $donasiTerbaru = Donasi::with('program')
            ->latest()
            ->take(5)
            ->get();

        $beritaTerbaru = Berita::with('penulis')
            ->latest()
            ->take(5)
            ->get();

        $perizinanPending = Perizinan::pending()
            ->latest()
            ->take(5)
            ->get();

        // Donation chart data (last 12 months)
        $donasiChart = Donasi::success()
            ->where('created_at', '>=', now()->subMonths(12))
            ->select(
                DB::raw('MONTH(created_at) as bulan'),
                DB::raw('YEAR(created_at) as tahun'),
                DB::raw('SUM(nominal) as total')
            )
            ->groupBy('tahun', 'bulan')
            ->orderBy('tahun')
            ->orderBy('bulan')
            ->get();

        return view('admin.dashboard.index', compact(
            'stats',
            'donasiTerbaru',
            'beritaTerbaru',
            'perizinanPending',
            'donasiChart'
        ));
    }
}
