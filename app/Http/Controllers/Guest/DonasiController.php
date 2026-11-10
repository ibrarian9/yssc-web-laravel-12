<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use App\Models\ProgramDonasi;
use App\Models\Donasi;
use App\Models\Profile;

class DonasiController extends Controller
{
    public function index()
    {
        $isDonasiActive = Profile::getCached()?->is_donasi_enabled ?? true;
        $totalDonasi = $isDonasiActive ? Donasi::success()->sum('nominal') : 0;
        $programs = $isDonasiActive
            ? ProgramDonasi::where('status', '!=', 'draft')
                ->withSum(['donasi as total_terkumpul' => fn($q) => $q->where('status_pembayaran', 'success')], 'nominal')
                ->withCount(['donasi as donatur_count' => fn($q) => $q->where('status_pembayaran', 'success')])
                ->ordered()
                ->get()
            : collect();

        return view('public.donasi.index', compact('totalDonasi', 'isDonasiActive', 'programs'));
    }

    public function show(string $slug)
    {
        $isDonasiActive = Profile::getCached()?->is_donasi_enabled ?? true;
        if (!$isDonasiActive) {
            return redirect()->route('donasi.index')->with('error', 'Layanan donasi saat ini sedang dinonaktifkan sementara.');
        }

        $program = ProgramDonasi::where('slug', $slug)
            ->where('status', '!=', 'draft')
            ->firstOrFail();

        $donasiTerbaru = Donasi::where('program_donasi_id', $program->id)
            ->success()
            ->latest()
            ->take(10)
            ->get();

        return view('public.donasi.show', compact('program', 'donasiTerbaru'));
    }
}
