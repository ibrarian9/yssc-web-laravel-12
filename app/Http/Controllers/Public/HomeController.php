<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use App\Models\ProgramDonasi;
use App\Models\Profile;
use App\Models\Slider;
use App\Models\Donasi;
use App\Models\AnggotaDevisi;

class HomeController extends Controller
{
    public function index()
    {
        $sliders = Slider::active()->ordered()->get();
        $profile = Profile::first();

        $programDonasi = ProgramDonasi::aktif()
            ->ordered()
            ->take(3)
            ->get();

        $beritaTerbaru = Berita::published()
            ->with(['kategori', 'penulis'])
            ->latest()
            ->take(6)
            ->get();

        $stats = [
            'total_donatur' => Donasi::success()->distinct('email_donatur')->count('email_donatur'),
            'total_donasi' => Donasi::success()->sum('nominal'),
            'kegiatan_selesai' => Berita::kegiatan()->published()->count(),
            'anggota_aktif' => AnggotaDevisi::active()->count(),
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
