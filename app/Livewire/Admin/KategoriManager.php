<?php

namespace App\Livewire\Admin;

use App\Models\Kategori;
use Livewire\Component;
use Illuminate\Support\Str;

class KategoriManager extends Component
{
    public string $search = '';
    public bool $showForm = false;
    public bool $isEditing = false;
    public ?int $editId = null;
    public string $nama = '';
    public string $deskripsi = '';
    public string $warna = '#0d9488';
    public bool $showDeleteConfirm = false;
    public ?int $deleteId = null;

    protected function rules()
    {
        return [
            'nama' => 'required|string|max:100',
            'deskripsi' => 'nullable|string|max:255',
            'warna' => 'required|string|max:7',
        ];
    }

    public function create(): void { $this->resetForm(); $this->showForm = true; }

    public function edit(int $id): void
    {
        $item = Kategori::findOrFail($id);
        $this->editId = $id;
        $this->isEditing = true;
        $this->nama = $item->nama;
        $this->deskripsi = $item->deskripsi ?? '';
        $this->warna = $item->warna ?? '#0d9488';
        $this->showForm = true;
    }

    public function save(): void
    {
        $this->validate();
        $data = ['nama' => $this->nama, 'slug' => Str::slug($this->nama), 'deskripsi' => $this->deskripsi ?: null, 'warna' => $this->warna];

        if ($this->isEditing) {
            Kategori::findOrFail($this->editId)->update($data);
            session()->flash('success', 'Kategori berhasil diperbarui.');
        } else {
            Kategori::create($data);
            session()->flash('success', 'Kategori berhasil ditambahkan.');
        }
        $this->resetForm();
        $this->showForm = false;
    }

    public function confirmDelete(int $id): void { $this->deleteId = $id; $this->showDeleteConfirm = true; }

    public function delete(): void
    {
        if ($this->deleteId) { Kategori::findOrFail($this->deleteId)->delete(); session()->flash('success', 'Kategori dihapus.'); }
        $this->showDeleteConfirm = false;
        $this->deleteId = null;
    }

    public function resetForm(): void { $this->reset(['nama', 'deskripsi', 'warna', 'editId', 'isEditing']); $this->warna = '#0d9488'; }

    public function render()
    {
        $items = Kategori::withCount('berita')
            ->when($this->search, fn($q) => $q->where('nama', 'like', "%{$this->search}%"))
            ->latest()->get();
        return view('livewire.admin.kategori-manager', ['items' => $items]);
    }
}
