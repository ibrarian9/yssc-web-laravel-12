<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use App\Models\Berita;

class BeritaController extends Controller
{
    public function index()
    {
        return view('public.berita.index');
    }

    public function show(string $slug)
    {
        $berita = Berita::where('slug', $slug)
            ->where('tipe', 'berita')
            ->published()
            ->with(['kategori', 'penulis'])
            ->firstOrFail();

        $berita->incrementViews();

        $related = Berita::published()
            ->where('id', '!=', $berita->id)
            ->where('kategori_id', $berita->kategori_id)
            ->latest()
            ->take(5)
            ->get();

        return view('public.berita.show', compact('berita', 'related'));
    }

    public function kegiatan()
    {
        return view('public.berita.kegiatan');
    }

    public function showKegiatan(string $slug)
    {
        $berita = Berita::where('slug', $slug)
            ->where('tipe', 'kegiatan')
            ->published()
            ->with(['kategori', 'penulis'])
            ->firstOrFail();

        $berita->incrementViews();

        $related = Berita::published()
            ->kegiatan()
            ->where('id', '!=', $berita->id)
            ->latest()
            ->take(5)
            ->get();

        return view('public.berita.show', compact('berita', 'related'));
    }
}