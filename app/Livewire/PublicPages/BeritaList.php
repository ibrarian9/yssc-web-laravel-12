<?php

namespace App\Livewire\PublicPages;

use App\Models\Berita;
use App\Models\Kategori;
use Livewire\Component;
use Livewire\WithPagination;

class BeritaList extends Component
{
    use WithPagination;

    public string $search = '';
    public string $tipe = '';
    public string $kategoriId = '';
    public string $sort = 'terbaru';
    public int $perPage = 12;

    protected $queryString = [
        'search' => ['except' => ''],
        'tipe' => ['except' => ''],
        'kategoriId' => ['except' => ''],
        'sort' => ['except' => 'terbaru'],
    ];

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingTipe(): void
    {
        $this->resetPage();
    }

    public function updatingKategoriId(): void
    {
        $this->resetPage();
    }

    public function updatingSort(): void
    {
        $this->resetPage();
    }

    public function setTipe(string $tipe): void
    {
        $this->tipe = $tipe;
        $this->resetPage();
    }

    public function render()
    {
        $query = Berita::published()->with(['kategori', 'penulis']);

        if ($this->search) {
            $query->search($this->search);
        }

        if ($this->tipe) {
            $query->where('tipe', $this->tipe);
        }

        if ($this->kategoriId) {
            $query->where('kategori_id', $this->kategoriId);
        }

        $query = match ($this->sort) {
            'terpopuler' => $query->orderByDesc('views'),
            'terlama' => $query->oldest(),
            default => $query->latest(),
        };

        return view('livewire.public.berita-list', [
            'items' => $query->paginate($this->perPage),
            'kategoriList' => Kategori::all(),
        ]);
    }
}
