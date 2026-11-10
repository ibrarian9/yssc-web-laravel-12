<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use App\Models\Relawan;
use Illuminate\Http\Request;

class RelawanController extends Controller
{
    public function index()
    {
        $relawan = Relawan::approved()
            ->latest('approved_at')
            ->paginate(12);

        return view('public.relawan.index', compact('relawan'));
    }

    public function form()
    {
        return view('public.relawan.form');
    }

    public function submit(Request $request)
    {
        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'telepon' => ['required', 'string', 'max:20'],
            'alamat' => ['nullable', 'string', 'max:500'],
            'tanggal_lahir' => ['nullable', 'date', 'before:today'],
            'pekerjaan' => ['nullable', 'string', 'max:255'],
            'motivasi' => ['required', 'string', 'min:20', 'max:1000'],
            'keahlian' => ['nullable', 'string', 'max:255'],
            'foto' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        if ($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')->store('relawan/foto', 'public');
        }

        // Link to user if logged in
        if (auth()->check()) {
            $validated['user_id'] = auth()->id();
        }

        Relawan::create($validated);

        return redirect()->route('relawan.form')
            ->with('success', 'Pendaftaran relawan berhasil! Tim kami akan meninjau data Anda.');
    }
}
