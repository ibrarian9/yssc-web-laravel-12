<?php

namespace App\Livewire\Mitra;

use App\Models\Berita;
use App\Models\Kategori;
use App\Models\Mitra;
use Illuminate\Support\Facades\Storage;
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
    public string $tipe = 'berita';
    public $thumbnail;
    public string $status = 'draft';

    protected function rules()
    {
        return [
            'judul' => 'required|string|max:255',
            'konten' => 'required|string',
            'kategoriId' => 'required|exists:kategori,id',
            'tipe' => 'required|in:berita,kegiatan',
            'status' => 'required|in:draft,published',
            'thumbnail' => $this->editId ? 'nullable|image|max:2048' : 'required|image|max:2048',
        ];
    }

    public function create(): void
    {
        $this->reset(['editId', 'judul', 'konten', 'kategoriId', 'thumbnail']);
        $this->tipe = 'berita';
        $this->status = 'draft';
        $this->resetErrorBag();
        $this->showForm = true;
    }

    public function edit(int $id): void
    {
        $berita = $this->getOwnBerita($id);
        if (!$berita) return;

        $this->editId = $berita->id;
        $this->judul = $berita->judul;
        $this->konten = $berita->konten;
        $this->kategoriId = (string) ($berita->kategori_id ?? '');
        $this->tipe = $berita->tipe ?? 'berita';
        $this->status = $berita->status ?? 'draft';
        $this->thumbnail = null;
        $this->resetErrorBag();
        $this->showForm = true;
    }

    public function save(): void
    {
        $this->validate();

        $data = [
            'judul' => $this->judul,
            'konten' => $this->konten,
            'kategori_id' => $this->kategoriId,
            'tipe' => $this->tipe,
            'status' => $this->status,
            'user_id' => auth()->id(),
        ];

        if ($this->thumbnail) {
            if ($this->editId) {
                $existing = $this->getOwnBerita($this->editId);
                if ($existing?->thumbnail && !str_starts_with($existing->thumbnail, 'http')) {
                    Storage::disk('public')->delete($existing->thumbnail);
                }
            }
            $data['thumbnail'] = $this->thumbnail->store('berita', 'public');
        }

        if ($this->editId) {
            $berita = $this->getOwnBerita($this->editId);
            abort_unless($berita, 403);
            $berita->update($data);
            session()->flash('success', 'Berita berhasil diperbarui.');
        } else {
            $data['slug'] = Str::slug($this->judul) . '-' . Str::lower(Str::random(5));
            Berita::create($data);
            session()->flash('success', 'Berita berhasil dibuat.');
        }

        $this->showForm = false;
        $this->reset(['editId', 'judul', 'konten', 'kategoriId', 'thumbnail']);
        $this->tipe = 'berita';
        $this->status = 'draft';
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
