<?php

namespace App\Livewire\PublicPages;

use App\Enums\JenisMitra;
use App\Mail\MitraRegisteredNotification;
use App\Models\Mitra;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;
use Livewire\WithFileUploads;

class MitraRegistrationForm extends Component
{
    use WithFileUploads;

    public string $jenisMitra = '';
    public string $namaPerusahaan = '';
    public string $email = '';
    public string $telepon = '';
    public string $npwp = '';
    public $dokumenNpwp;
    public $dokumenLegalitas;
    public bool $agreeTerms = false;
    public bool $submitted = false;

    protected function rules()
    {
        return [
            'jenisMitra' => 'required|in:perusahaan,organisasi,perorangan,lembaga',
            'namaPerusahaan' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:mitra,email',
            'telepon' => 'required|string|max:20',
            'npwp' => 'required|string|max:30',
            'dokumenNpwp' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'dokumenLegalitas' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'agreeTerms' => 'accepted',
        ];
    }

    protected $messages = [
        'jenisMitra.required' => 'Pilih jenis mitra.',
        'namaPerusahaan.required' => 'Nama perusahaan wajib diisi.',
        'email.required' => 'Email wajib diisi.',
        'email.unique' => 'Email sudah terdaftar sebagai mitra.',
        'telepon.required' => 'Nomor telepon wajib diisi.',
        'npwp.required' => 'Nomor NPWP wajib diisi.',
        'dokumenNpwp.required' => 'Upload dokumen verifikasi NPWP.',
        'dokumenNpwp.max' => 'Dokumen NPWP maksimal 5MB.',
        'dokumenLegalitas.required' => 'Upload dokumen legalitas.',
        'dokumenLegalitas.max' => 'Dokumen legalitas maksimal 5MB.',
        'agreeTerms.accepted' => 'Anda harus menyetujui syarat dan ketentuan.',
    ];

    public function submit()
    {
        $this->validate();

        $npwpPath = $this->dokumenNpwp->store('mitra/npwp', 'public');
        $legalitasPath = $this->dokumenLegalitas->store('mitra/legalitas', 'public');

        $mitra = Mitra::create([
            'jenis_mitra' => $this->jenisMitra,
            'nama_perusahaan' => $this->namaPerusahaan,
            'email' => $this->email,
            'telepon' => $this->telepon,
            'npwp' => $this->npwp,
            'dokumen_npwp' => $npwpPath,
            'dokumen_legalitas' => $legalitasPath,
            'status' => 'pending',
        ]);

        // Send notification to all admin users
        $admins = User::whereIn('role', ['superadmin', 'admin'])->pluck('email');
        foreach ($admins as $adminEmail) {
            Mail::to($adminEmail)->send(new MitraRegisteredNotification($mitra));
        }

        $this->submitted = true;
    }

    public function render()
    {
        return view('livewire.public.mitra-registration-form', [
            'jenisOptions' => JenisMitra::cases(),
        ]);
    }
}
