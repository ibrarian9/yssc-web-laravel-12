<?php

namespace App\Livewire\Mitra;

use App\Models\Donasi;
use App\Models\Mitra;
use App\Models\ProgramDonasi;
use Livewire\Component;

class MitraDashboard extends Component
{
    public function render()
    {
        $user = auth()->user();
        $mitra = Mitra::where('user_id', $user->id)->first();

        $programIds = $mitra
            ? ProgramDonasi::where('mitra_id', $mitra->id)->pluck('id')
            : collect();

        $totalPrograms = $programIds->count();
        $totalDonasi = Donasi::whereIn('program_donasi_id', $programIds)->where('status_pembayaran', 'success')->sum('nominal');
        $totalDonatur = Donasi::whereIn('program_donasi_id', $programIds)->where('status_pembayaran', 'success')->distinct('email_donatur')->count('email_donatur');
        $recentDonations = Donasi::whereIn('program_donasi_id', $programIds)
            ->where('status_pembayaran', 'success')
            ->with('programDonasi')
            ->latest()
            ->take(5)
            ->get();

        return view('livewire.mitra.mitra-dashboard', compact('mitra', 'totalPrograms', 'totalDonasi', 'totalDonatur', 'recentDonations'));
    }
}
