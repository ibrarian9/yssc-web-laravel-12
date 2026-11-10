<?php

namespace App\Livewire\Admin;

use App\Models\Profile;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class ProfilManager extends Component
{
    use WithFileUploads;

    public string $activeTab = 'identitas'; // identitas, visi_misi, sejarah, kontak_sosmed, pratinjau

    public string $nama_organisasi = '';
    public string $tagline = '';
    public string $deskripsi = '';
    public string $visi = '';
    public array $misi = [''];
    public string $sejarah = '';
    public string $alamat = '';
    public string $email = '';
    public string $telepon = '';
    public string $website = '';
    public string $instagram = '';
    public string $facebook = '';
    public string $youtube = '';

    public $newLogo;
    public ?string $currentLogo = null;

    public $newFotoKantor;
    public ?string $currentFotoKantor = null;

    protected function rules(): array
    {
        return [
            'nama_organisasi' => 'required|string|max:255',
            'tagline' => 'nullable|string|max:255',
            'deskripsi' => 'nullable|string',
            'visi' => 'nullable|string',
            'misi' => 'nullable|array',
            'misi.*' => 'nullable|string|max:255',
            'sejarah' => 'nullable|string',
            'alamat' => 'nullable|string',
            'email' => 'nullable|email|max:255',
            'telepon' => 'nullable|string|max:25',
            'website' => 'nullable|string|max:255',
            'instagram' => 'nullable|string|max:255',
            'facebook' => 'nullable|string|max:255',
            'youtube' => 'nullable|string|max:255',
            'newLogo' => 'nullable|image|max:2048',
            'newFotoKantor' => 'nullable|image|max:4096',
        ];
    }

    protected array $messages = [
        'nama_organisasi.required' => 'Nama organisasi / yayasan wajib diisi.',
        'email.email' => 'Format email tidak valid.',
        'newLogo.image' => 'File logo harus berupa gambar (PNG/JPG).',
        'newLogo.max' => 'Ukuran file logo maksimal 2MB.',
        'newFotoKantor.image' => 'Foto kantor harus berupa gambar.',
        'newFotoKantor.max' => 'Ukuran foto kantor maksimal 4MB.',
    ];

    public function mount(): void
    {
        $p = Profile::first();
        if ($p) {
            $this->nama_organisasi = $p->nama_organisasi ?? '';
            $this->tagline = $p->tagline ?? '';
            $this->deskripsi = $p->deskripsi ?? '';
            $this->visi = $p->visi ?? '';
            $this->misi = is_array($p->misi) && count($p->misi) > 0 ? array_values($p->misi) : [''];
            $this->sejarah = $p->sejarah ?? '';
            $this->alamat = $p->alamat ?? '';
            $this->email = $p->email ?? '';
            $this->telepon = $p->telepon ?? '';
            $this->website = $p->website ?? '';
            $this->instagram = $p->instagram ?? '';
            $this->facebook = $p->facebook ?? '';
            $this->youtube = $p->youtube ?? '';
            $this->currentLogo = $p->logo ?? null;
            $this->currentFotoKantor = $p->foto_kantor ?? null;
        } else {
            $this->nama_organisasi = 'Yayasan Seribu Satu Cita';
        }
    }

    public function setTab(string $tab): void
    {
        $this->activeTab = $tab;
    }

    public function addMisi(): void
    {
        $this->misi[] = '';
    }

    public function removeMisi(int $idx): void
    {
        unset($this->misi[$idx]);
        $this->misi = array_values($this->misi);
        if (empty($this->misi)) {
            $this->misi = [''];
        }
    }

    public function removeLogo(): void
    {
        $this->newLogo = null;
        $p = Profile::first();
        if ($p && $p->logo) {
            Storage::disk('public')->delete($p->logo);
            $p->update(['logo' => null]);
            $this->currentLogo = null;
            session()->flash('success', 'Logo profil berhasil dihapus.');
        }
    }

    public function removeFotoKantor(): void
    {
        $this->newFotoKantor = null;
        $p = Profile::first();
        if ($p && $p->foto_kantor) {
            Storage::disk('public')->delete($p->foto_kantor);
            $p->update(['foto_kantor' => null]);
            $this->currentFotoKantor = null;
            session()->flash('success', 'Foto kantor berhasil dihapus.');
        }
    }

    public function save(): void
    {
        $this->validate();

        // Filter empty strings from misi
        $cleanedMisi = array_values(array_filter(array_map('trim', $this->misi)));

        $data = [
            'nama_organisasi' => $this->nama_organisasi,
            'tagline' => $this->tagline ?: null,
            'deskripsi' => $this->deskripsi ?: null,
            'visi' => $this->visi ?: null,
            'misi' => !empty($cleanedMisi) ? $cleanedMisi : null,
            'sejarah' => $this->sejarah ?: null,
            'alamat' => $this->alamat ?: null,
            'email' => $this->email ?: null,
            'telepon' => $this->telepon ?: null,
            'website' => $this->website ?: null,
            'instagram' => $this->instagram ?: null,
            'facebook' => $this->facebook ?: null,
            'youtube' => $this->youtube ?: null,
        ];

        $p = Profile::first();

        if ($this->newLogo) {
            if ($p && $p->logo) {
                Storage::disk('public')->delete($p->logo);
            }
            $data['logo'] = $this->newLogo->store('profil', 'public');
            $this->currentLogo = $data['logo'];
            $this->newLogo = null;
        }

        if ($this->newFotoKantor) {
            if ($p && $p->foto_kantor) {
                Storage::disk('public')->delete($p->foto_kantor);
            }
            $data['foto_kantor'] = $this->newFotoKantor->store('profil', 'public');
            $this->currentFotoKantor = $data['foto_kantor'];
            $this->newFotoKantor = null;
        }

        if ($p) {
            $p->update($data);
        } else {
            Profile::create($data);
        }

        session()->flash('success', 'Profil organisasi berhasil disimpan dan diperbarui di website!');
    }

    public function render()
    {
        return view('livewire.admin.profil-manager');
    }
}
