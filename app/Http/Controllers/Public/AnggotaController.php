<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Divisi;

class AnggotaController extends Controller
{
    public function index()
    {
        $divisi = Divisi::active()
            ->ordered()
            ->with('anggotaAktif')
            ->get();

        return view('public.anggota.index', compact('divisi'));
    }
}
