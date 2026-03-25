<?php

namespace App\Livewire\Admin;

use App\Models\Profile;
use Livewire\Component;
use Livewire\WithFileUploads;

class ProfilManager extends Component
{
    use WithFileUploads;

    public string $nama_organisasi = '';
    public string $tagline = '';
    public string $deskripsi = '';
    public string $visi = '';
    public array $misi = [''];
    public string $sejarah = '';
    public string $alamat = '';
    public string $email = '';
    public string $telepon = '';
    public string $whatsapp = '';
    public string $instagram = '';
    public string $facebook = '';
    public string $youtube = '';
    public $newLogo;
    public bool $saved = false;

    protected function rules() { return [
        'nama_organisasi' => 'required|string|max:255',
        'tagline' => 'nullable|string|max:255',
        'deskripsi' => 'nullable|string',
        'visi' => 'nullable|string',
        'misi' => 'nullable|array',
        'sejarah' => 'nullable|string',
        'alamat' => 'nullable|string',
        'email' => 'nullable|email',
        'telepon' => 'nullable|string|max:20',
        'newLogo' => 'nullable|image|max:1024',
    ]; }

    public function mount(): void
    {
        $p = Profile::first();
        if ($p) {
            $this->nama_organisasi = $p->nama_organisasi ?? '';
            $this->tagline = $p->tagline ?? '';
            $this->deskripsi = $p->deskripsi ?? '';
            $this->visi = $p->visi ?? '';
            $this->misi = $p->misi ?? [''];
            $this->sejarah = $p->sejarah ?? '';
            $this->alamat = $p->alamat ?? '';
            $this->email = $p->email ?? '';
            $this->telepon = $p->telepon ?? '';
            $this->whatsapp = $p->whatsapp ?? '';
            $this->instagram = $p->instagram ?? '';
            $this->facebook = $p->facebook ?? '';
            $this->youtube = $p->youtube ?? '';
        }
    }

    public function addMisi(): void { $this->misi[] = ''; }
    public function removeMisi(int $idx): void { unset($this->misi[$idx]); $this->misi = array_values($this->misi); }

    public function save(): void
    {
        $this->validate();
        $data = [
            'nama_organisasi' => $this->nama_organisasi, 'tagline' => $this->tagline ?: null,
            'deskripsi' => $this->deskripsi ?: null, 'visi' => $this->visi ?: null,
            'misi' => array_filter($this->misi), 'sejarah' => $this->sejarah ?: null,
            'alamat' => $this->alamat ?: null, 'email' => $this->email ?: null,
            'telepon' => $this->telepon ?: null, 'whatsapp' => $this->whatsapp ?: null,
            'instagram' => $this->instagram ?: null, 'facebook' => $this->facebook ?: null,
            'youtube' => $this->youtube ?: null,
        ];
        if ($this->newLogo) { $data['logo'] = $this->newLogo->store('profil', 'public'); }
        Profile::updateOrCreate(['id' => Profile::first()?->id ?? 0], $data);
        session()->flash('success', 'Profil berhasil disimpan.');
        $this->saved = true;
    }

    public function render() { return view('livewire.admin.profil-manager'); }
}
