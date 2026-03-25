<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use App\Models\ProgramDonasi;
use App\Models\Donasi;

class DonasiController extends Controller
{
    public function index()
    {
        $totalDonasi = Donasi::success()->sum('nominal');

        return view('public.donasi.index', compact('totalDonasi'));
    }

    public function show(string $slug)
    {
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