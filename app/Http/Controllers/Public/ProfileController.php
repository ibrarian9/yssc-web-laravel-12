<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use App\Models\DokumenLegal;
use App\Models\AnggotaDevisi;
use App\Models\Mitra;

class ProfileController extends Controller
{
    public function index()
    {
        $profile = Profile::first();
        $dokumen = DokumenLegal::where('is_public', true)->get();

        // Key team members for "Tim Kami" section
        $teamMembers = AnggotaDevisi::where('is_active', true)
            ->with('divisi')
            ->orderBy('created_at')
            ->take(6)
            ->get();

        // Approved partners for "Mitra Kami" section
        $mitraApproved = Mitra::approved()->latest('approved_at')->get();

        return view('public.profile.index', compact('profile', 'dokumen', 'teamMembers', 'mitraApproved'));
    }
}
