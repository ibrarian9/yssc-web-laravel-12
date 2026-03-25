<?php

namespace App\Livewire\PublicPages;

use App\Models\Donasi;
use App\Models\ProgramDonasi;
use App\Services\MidtransService;
use Livewire\Component;

class DonasiForm extends Component
{
    public int $programId;
    public int $nominal = 0;
    public string $namaCustom = '';
    public string $emailCustom = '';
    public string $phone = '';
    public string $pesan = '';
    public bool $isAnonim = false;
    public bool $submitted = false;
    public ?string $snapToken = null;
    public ?string $errorMsg = null;

    protected function rules()
    {
        return [
            'nominal' => 'required|numeric|min:10000',
            'namaCustom' => 'required|string|max:255',
            'emailCustom' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'pesan' => 'nullable|string|max:500',
        ];
    }

    protected $messages = [
        'nominal.required' => 'Pilih nominal donasi.',
        'nominal.min' => 'Minimal donasi Rp 10.000.',
        'namaCustom.required' => 'Nama wajib diisi.',
        'emailCustom.required' => 'Email wajib diisi.',
        'emailCustom.email' => 'Format email tidak valid.',
    ];

    public function mount(int $programId)
    {
        $this->programId = $programId;

        if (auth()->check()) {
            $this->namaCustom = auth()->user()->name;
            $this->emailCustom = auth()->user()->email;
            $this->phone = auth()->user()->phone ?? '';
        }
    }

    public function setNominal(int $amount)
    {
        $this->nominal = $amount;
    }

    public function submit()
    {
        $this->validate();
        $this->errorMsg = null;

        $program = ProgramDonasi::findOrFail($this->programId);

        // Create pending donation record
        $donasi = Donasi::create([
            'program_donasi_id' => $this->programId,
            'user_id' => auth()->id(),
            'nama_donatur' => $this->namaCustom,
            'email_donatur' => $this->emailCustom,
            'phone' => $this->phone,
            'nominal' => $this->nominal,
            'pesan' => $this->pesan,
            'is_anonim' => $this->isAnonim,
            'metode_pembayaran' => 'midtrans',
            'status_pembayaran' => 'pending',
        ]);

        // Get Snap token from Midtrans
        $midtrans = app(MidtransService::class);
        $snapToken = $midtrans->createSnapToken($donasi);

        if ($snapToken) {
            $this->snapToken = $snapToken;
            // Dispatch browser event to open Snap popup
            $this->dispatch('open-snap', token: $snapToken);
        } else {
            $this->errorMsg = 'Gagal membuat transaksi pembayaran. Silakan coba lagi.';
            // Still mark as submitted so user can retry
            $donasi->update(['status_pembayaran' => 'failed']);
        }
    }

    public function paymentSuccess()
    {
        $this->submitted = true;
    }

    public function paymentPending()
    {
        $this->submitted = true;
    }

    public function paymentError()
    {
        $this->errorMsg = 'Pembayaran gagal. Silakan coba lagi.';
    }

    public function render()
    {
        return view('livewire.public.donasi-form');
    }
}
