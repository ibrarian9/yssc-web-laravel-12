<?php

namespace App\Livewire\Mitra;

use App\Models\Berita;
use App\Models\Kategori;
use App\Models\Mitra;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class MitraBeritaManager extends Component
{
    use WithPagination, WithFileUploads;

    public bool $showForm = false;
    public ?int $editId = null;
    public string $judul = '';
    public string $konten = '';
    public string $kategoriId = '';
    public string $jenis = 'berita';
    public $thumbnail;
    public bool $isPublished = false;

    protected function rules()
    {
        return [
            'judul' => 'required|string|max:255',
            'konten' => 'required|string',
            'kategoriId' => 'required|exists:kategori,id',
            'jenis' => 'required|in:berita,kegiatan',
            'thumbnail' => $this->editId ? 'nullable|image|max:2048' : 'required|image|max:2048',
        ];
    }

    public function create(): void
    {
        $this->reset(['editId', 'judul', 'konten', 'kategoriId', 'jenis', 'thumbnail', 'isPublished']);
        $this->showForm = true;
    }

    public function edit(int $id): void
    {
        $berita = $this->getOwnBerita($id);
        if (!$berita) return;

        $this->editId = $berita->id;
        $this->judul = $berita->judul;
        $this->konten = $berita->konten;
        $this->kategoriId = $berita->kategori_id;
        $this->jenis = $berita->jenis;
        $this->isPublished = $berita->is_published;
        $this->showForm = true;
    }

    public function save(): void
    {
        $this->validate();

        $data = [
            'judul' => $this->judul,
            'slug' => \Str::slug($this->judul) . '-' . time(),
            'konten' => $this->konten,
            'kategori_id' => $this->kategoriId,
            'jenis' => $this->jenis,
            'is_published' => $this->isPublished,
            'user_id' => auth()->id(),
        ];

        if ($this->isPublished) {
            $data['published_at'] = now();
        }

        if ($this->thumbnail) {
            $data['thumbnail'] = $this->thumbnail->store('berita', 'public');
        }

        if ($this->editId) {
            $berita = $this->getOwnBerita($this->editId);
            $berita?->update($data);
            session()->flash('success', 'Berita berhasil diperbarui.');
        } else {
            Berita::create($data);
            session()->flash('success', 'Berita berhasil dibuat.');
        }

        $this->showForm = false;
    }

    public function deleteBerita(int $id): void
    {
        $berita = $this->getOwnBerita($id);
        $berita?->delete();
        session()->flash('success', 'Berita berhasil dihapus.');
    }

    private function getOwnBerita(int $id): ?Berita
    {
        return Berita::where('id', $id)->where('user_id', auth()->id())->first();
    }

    public function render()
    {
        $beritaList = Berita::where('user_id', auth()->id())
            ->with('kategori')
            ->latest()
            ->paginate(10);

        $kategoriOptions = Kategori::orderBy('nama')->get();

        return view('livewire.mitra.mitra-berita-manager', compact('beritaList', 'kategoriOptions'));
    }
}
