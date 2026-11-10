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

        // Single aggregate query for totals instead of 2 separate ones
        $stats = Donasi::whereIn('program_donasi_id', $programIds)
            ->where('status_pembayaran', 'success')
            ->selectRaw('COALESCE(SUM(nominal), 0) as total_donasi, COUNT(DISTINCT email_donatur) as total_donatur')
            ->first();

        $recentDonations = $programIds->isNotEmpty()
            ? Donasi::whereIn('program_donasi_id', $programIds)
                ->where('status_pembayaran', 'success')
                ->with('programDonasi:id,judul')
                ->latest()
                ->take(5)
                ->get()
            : collect();

        $totalDonasi = $stats->total_donasi ?? 0;
        $totalDonatur = $stats->total_donatur ?? 0;

        return view('livewire.mitra.mitra-dashboard', compact('mitra', 'totalPrograms', 'totalDonasi', 'totalDonatur', 'recentDonations'));
    }
}
