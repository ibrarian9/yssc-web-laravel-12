<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use App\Models\ProgramDonasi;
use App\Models\Profile;
use App\Models\Slider;
use App\Models\Donasi;
use App\Models\AnggotaDevisi;
use App\Models\Mitra;
use App\Models\Relawan;

class HomeController extends Controller
{
    public function index()
    {
        $sliders = Slider::active()->ordered()->get();
        $profile = Profile::getCached();
        $isDonasiActive = $profile?->is_donasi_enabled ?? true;

        $programDonasi = $isDonasiActive
            ? ProgramDonasi::aktif()
                ->withSum(['donasi as total_terkumpul' => fn($q) => $q->where('status_pembayaran', 'success')], 'nominal')
                ->withCount(['donasi as donatur_count' => fn($q) => $q->where('status_pembayaran', 'success')])
                ->ordered()
                ->take(3)
                ->get()
            : collect();

        $beritaTerbaru = Berita::published()
            ->with(['kategori', 'penulis'])
            ->latest()
            ->take(6)
            ->get();

        $donasiStats = $isDonasiActive
            ? Donasi::success()
                ->selectRaw('COUNT(DISTINCT email_donatur) as total_donatur, COALESCE(SUM(nominal), 0) as total_donasi')
                ->first()
            : null;

        $stats = [
            'total_donatur' => (int) ($donasiStats->total_donatur ?? 0),
            'total_donasi' => (int) ($donasiStats->total_donasi ?? 0),
            'kegiatan_selesai' => Berita::kegiatan()->published()->count(),
            'anggota_aktif' => AnggotaDevisi::active()->count(),
            'relawan_aktif' => Relawan::approved()->count(),
            'mitra_aktif' => Mitra::approved()->count(),
        ];

        return view('public.home.index', compact(
            'sliders',
            'profile',
            'programDonasi',
            'beritaTerbaru',
            'stats'
        ));
    }
}
