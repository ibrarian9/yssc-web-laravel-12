<?php

namespace App\Livewire\Admin;

use App\Models\ProgramDonasi;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Str;

class ProgramDonasiManager extends Component
{
    use WithPagination, WithFileUploads;

    public string $search = '';
    public bool $showForm = false;
    public bool $isEditing = false;
    public ?int $editId = null;
    public string $judul = '';
    public string $deskripsi = '';
    public float $target_nominal = 0;
    public string $status = 'draft';
    public bool $is_mendesak = false;
    public ?string $tanggal_selesai = '';
    public $newThumbnail;
    public bool $showDeleteConfirm = false;
    public ?int $deleteId = null;

    protected function rules() { return ['judul' => 'required|string|max:255', 'deskripsi' => 'required|string', 'target_nominal' => 'required|numeric|min:100000', 'status' => 'required|in:draft,aktif,selesai', 'tanggal_selesai' => 'nullable|date', 'newThumbnail' => 'nullable|image|max:2048']; }

    public function create(): void { $this->reset(['judul', 'deskripsi', 'target_nominal', 'status', 'is_mendesak', 'tanggal_selesai', 'newThumbnail', 'editId', 'isEditing']); $this->status = 'draft'; $this->showForm = true; }

    public function edit(int $id): void
    {
        $p = ProgramDonasi::findOrFail($id);
        $this->editId = $id; $this->isEditing = true;
        $this->judul = $p->judul; $this->deskripsi = $p->deskripsi; $this->target_nominal = $p->target_nominal;
        $this->status = $p->status; $this->is_mendesak = $p->is_mendesak;
        $this->tanggal_selesai = $p->tanggal_selesai?->format('Y-m-d') ?? '';
        $this->showForm = true;
    }

    public function save(): void
    {
        $this->validate();
        $data = ['judul' => $this->judul, 'slug' => Str::slug($this->judul), 'deskripsi' => $this->deskripsi, 'target_nominal' => $this->target_nominal, 'status' => $this->status, 'is_mendesak' => $this->is_mendesak, 'tanggal_selesai' => $this->tanggal_selesai ?: null];
        if ($this->newThumbnail) { $data['thumbnail'] = $this->newThumbnail->store('program-donasi', 'public'); }
        if ($this->isEditing) { ProgramDonasi::findOrFail($this->editId)->update($data); session()->flash('success', 'Program diperbarui.'); }
        else { ProgramDonasi::create($data); session()->flash('success', 'Program ditambahkan.'); }
        $this->showForm = false;
    }

    public function confirmDelete(int $id): void { $this->deleteId = $id; $this->showDeleteConfirm = true; }
    public function delete(): void { if ($this->deleteId) { ProgramDonasi::findOrFail($this->deleteId)->delete(); session()->flash('success', 'Program dihapus.'); } $this->showDeleteConfirm = false; }

    public function render()
    {
        $query = ProgramDonasi::withCount('donasi')->withSum(['donasi as total_donasi' => fn($q) => $q->where('status_pembayaran', 'success')], 'nominal');
        if ($this->search) { $query->where('judul', 'like', "%{$this->search}%"); }
        return view('livewire.admin.program-donasi-manager', ['items' => $query->latest()->paginate(10)]);
    }
}
