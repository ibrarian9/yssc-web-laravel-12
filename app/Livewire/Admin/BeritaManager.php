<?php

namespace App\Livewire\Admin;

use App\Models\Berita;
use App\Models\Kategori;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Str;

class BeritaManager extends Component
{
    use WithPagination, WithFileUploads;

    // Filter
    public string $search = '';
    public string $tipeFilter = '';
    public string $statusFilter = '';

    // Form
    public bool $showForm = false;
    public bool $isEditing = false;
    public ?int $editId = null;
    public string $judul = '';
    public string $konten = '';
    public string $tipe = 'berita';
    public string $status = 'draft';
    public ?int $kategori_id = null;
    public ?string $thumbnail = '';
    public ?string $lokasi = '';
    public ?string $tanggal_kegiatan = '';
    public $newThumbnail;

    // Delete
    public bool $showDeleteConfirm = false;
    public ?int $deleteId = null;

    protected function rules()
    {
        return [
            'judul' => 'required|string|max:255',
            'konten' => 'required|string',
            'tipe' => 'required|in:berita,kegiatan',
            'status' => 'required|in:draft,published',
            'kategori_id' => 'nullable|exists:kategori,id',
            'thumbnail' => 'nullable|string',
            'lokasi' => 'nullable|string|max:255',
            'tanggal_kegiatan' => 'nullable|date',
            'newThumbnail' => 'nullable|image|max:2048',
        ];
    }

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function create(): void
    {
        $this->resetForm();
        $this->showForm = true;
    }

    public function edit(int $id): void
    {
        $berita = Berita::findOrFail($id);
        $this->editId = $id;
        $this->isEditing = true;
        $this->judul = $berita->judul;
        $this->konten = $berita->konten;
        $this->tipe = $berita->tipe;
        $this->status = $berita->status;
        $this->kategori_id = $berita->kategori_id;
        $this->thumbnail = $berita->thumbnail ?? '';
        $this->lokasi = $berita->lokasi ?? '';
        $this->tanggal_kegiatan = $berita->tanggal_kegiatan?->format('Y-m-d') ?? '';
        $this->showForm = true;
    }

    public function save(): void
    {
        $this->validate();

        $data = [
            'judul' => $this->judul,
            'slug' => Str::slug($this->judul),
            'konten' => $this->konten,
            'tipe' => $this->tipe,
            'status' => $this->status,
            'kategori_id' => $this->kategori_id ?: null,
            'thumbnail' => $this->thumbnail ?: null,
            'lokasi' => $this->lokasi ?: null,
            'tanggal_kegiatan' => $this->tanggal_kegiatan ?: null,
        ];

        if ($this->newThumbnail) {
            $data['thumbnail'] = $this->newThumbnail->store('berita', 'public');
        }

        if ($this->isEditing) {
            $berita = Berita::findOrFail($this->editId);
            if (!$this->newThumbnail) {
                unset($data['thumbnail']);
            }
            $berita->update($data);
            session()->flash('success', 'Berita berhasil diperbarui.');
        } else {
            $data['user_id'] = auth()->id();
            Berita::create($data);
            session()->flash('success', 'Berita berhasil ditambahkan.');
        }

        $this->resetForm();
        $this->showForm = false;
    }

    public function confirmDelete(int $id): void
    {
        $this->deleteId = $id;
        $this->showDeleteConfirm = true;
    }

    public function delete(): void
    {
        if ($this->deleteId) {
            Berita::findOrFail($this->deleteId)->delete();
            session()->flash('success', 'Berita berhasil dihapus.');
        }
        $this->showDeleteConfirm = false;
        $this->deleteId = null;
    }

    public function toggleStatus(int $id): void
    {
        $berita = Berita::findOrFail($id);
        $berita->update(['status' => $berita->status === 'published' ? 'draft' : 'published']);
    }

    public function resetForm(): void
    {
        $this->reset(['judul', 'konten', 'tipe', 'status', 'kategori_id', 'thumbnail', 'lokasi', 'tanggal_kegiatan', 'newThumbnail', 'editId', 'isEditing']);
        $this->tipe = 'berita';
        $this->status = 'draft';
    }

    public function render()
    {
        $query = Berita::with(['kategori', 'penulis'])->withTrashed();

        if ($this->search) {
            $query->search($this->search);
        }
        if ($this->tipeFilter) {
            $query->where('tipe', $this->tipeFilter);
        }
        if ($this->statusFilter) {
            $query->where('status', $this->statusFilter);
        }

        return view('livewire.admin.berita-manager', [
            'items' => $query->latest()->paginate(15),
            'kategoriList' => Kategori::all(),
        ]);
    }
}
