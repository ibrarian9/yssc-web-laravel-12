<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use App\Models\Perizinan;
use Illuminate\Http\Request;

class PerizinanController extends Controller
{
    public function form()
    {
        return view('public.perizinan.form');
    }

    public function submit(Request $request)
    {
        $validated = $request->validate([
            'nama_pemohon' => 'required|string|max:255',
            'email_pemohon' => 'required|email|max:255',
            'phone_pemohon' => 'nullable|string|max:20',
            'jenis_izin' => 'required|in:kegiatan,kerjasama,rekomendasi,lainnya',
            'judul_permohonan' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'dokumen_pendukung.*' => 'nullable|file|max:5120',
        ]);

        $dokumen = [];
        if ($request->hasFile('dokumen_pendukung')) {
            foreach ($request->file('dokumen_pendukung') as $file) {
                $dokumen[] = $file->store('perizinan/dokumen', 'public');
            }
        }

        Perizinan::create([
            ...$validated,
            'dokumen_pendukung' => $dokumen,
            'tanggal_permohonan' => now(),
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('perizinan.form')
            ->with('success', 'Permohonan izin berhasil diajukan! Kami akan memproses permohonan Anda.');
    }

    public function cek(Request $request)
    {
        $perizinan = null;

        if ($request->has('email')) {
            $perizinan = Perizinan::where('email_pemohon', $request->email)
                ->latest()
                ->get();
        }

        return view('public.perizinan.cek', compact('perizinan'));
    }
}