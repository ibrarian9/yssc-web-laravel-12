<?php

namespace App\Livewire\Admin;

use App\Models\HeroSection;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class HeroSectionManager extends Component
{
    use WithFileUploads;

    public bool $showModal = false;
    public ?int $selectedId = null;

    public string $page_key = '';
    public string $page_name = '';
    public string $route_name = '';
    public string $judul = '';
    public string $subjudul = '';
    public int $overlay_opacity = 60;
    public bool $is_active = true;
    public $newGambar;
    public ?string $existingGambar = null;

    protected function rules(): array
    {
        return [
            'judul' => 'required|string|max:255',
            'subjudul' => 'nullable|string|max:500',
            'overlay_opacity' => 'required|integer|min:10|max:90',
            'newGambar' => 'nullable|image|max:5120',
            'is_active' => 'boolean',
        ];
    }

    protected array $messages = [
        'judul.required' => 'Judul hero section wajib diisi.',
        'overlay_opacity.required' => 'Pilih tingkat kepekatan overlay.',
        'newGambar.image' => 'File harus berupa gambar (JPG, PNG, atau WEBP).',
        'newGambar.max' => 'Ukuran gambar maksimal 5MB.',
    ];

    public function mount(): void
    {
        HeroSection::syncDefaults();
    }

    public function edit(int $id): void
    {
        $hero = HeroSection::findOrFail($id);
        $this->selectedId = $id;
        $this->page_key = $hero->page_key;
        $this->page_name = $hero->page_name;
        $this->route_name = $hero->route_name ?? '';
        $this->judul = $hero->judul ?? '';
        $this->subjudul = $hero->subjudul ?? '';
        $this->overlay_opacity = $hero->overlay_opacity ?? 60;
        $this->is_active = (bool) $hero->is_active;
        $this->existingGambar = $hero->gambar;
        $this->newGambar = null;
        $this->resetErrorBag();
        $this->showModal = true;
    }

    public function save(): void
    {
        $this->validate();

        $hero = HeroSection::findOrFail($this->selectedId);

        $data = [
            'judul' => $this->judul,
            'subjudul' => $this->subjudul ?: null,
            'overlay_opacity' => $this->overlay_opacity,
            'is_active' => $this->is_active,
        ];

        if ($this->newGambar) {
            if ($hero->gambar) {
                Storage::disk('public')->delete($hero->gambar);
            }
            $data['gambar'] = $this->newGambar->store('heroes', 'public');
            $this->existingGambar = $data['gambar'];
            $this->newGambar = null;
        }

        $hero->update($data);

        session()->flash('success', "Hero section untuk menu \"{$hero->page_name}\" berhasil diperbarui.");
        $this->showModal = false;
    }

    public function removeGambar(int $id): void
    {
        $hero = HeroSection::findOrFail($id);
        if ($hero->gambar) {
            Storage::disk('public')->delete($hero->gambar);
            $hero->update(['gambar' => null]);
            $this->existingGambar = null;
            session()->flash('success', "Gambar hero menu \"{$hero->page_name}\" berhasil dihapus.");
        }
    }

    public function toggleActive(int $id): void
    {
        $hero = HeroSection::findOrFail($id);
        $hero->update(['is_active' => !$hero->is_active]);
        $status = $hero->is_active ? 'diaktifkan' : 'dinonaktifkan';
        session()->flash('success', "Hero section menu \"{$hero->page_name}\" telah {$status}.");
    }

    public function render()
    {
        return view('livewire.admin.hero-section-manager', [
            'heroes' => HeroSection::orderBy('id', 'asc')->get(),
        ]);
    }
}

