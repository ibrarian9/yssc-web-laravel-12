<?php

namespace App\Livewire\Admin;

use App\Models\Slider;
use Livewire\Component;
use Livewire\WithFileUploads;

class SliderManager extends Component
{
    use WithFileUploads;

    public bool $showForm = false;
    public bool $isEditing = false;
    public ?int $editId = null;
    public string $judul = '';
    public string $deskripsi = '';
    public string $link = '';
    public string $tombol_teks = 'Selengkapnya';
    public int $urutan = 0;
    public bool $is_active = true;
    public $newGambar;
    public bool $showDeleteConfirm = false;
    public ?int $deleteId = null;

    protected function rules() { return ['judul' => 'required|string|max:255', 'deskripsi' => 'nullable|string', 'link' => 'nullable|string|max:255', 'tombol_teks' => 'nullable|string|max:50', 'urutan' => 'integer|min:0', 'newGambar' => $this->isEditing ? 'nullable|image|max:3072' : 'required|image|max:3072']; }

    public function create(): void { $this->reset(['judul', 'deskripsi', 'link', 'tombol_teks', 'urutan', 'is_active', 'newGambar', 'editId', 'isEditing']); $this->tombol_teks = 'Selengkapnya'; $this->is_active = true; $this->showForm = true; }

    public function edit(int $id): void
    {
        $s = Slider::findOrFail($id);
        $this->editId = $id; $this->isEditing = true;
        $this->judul = $s->judul; $this->deskripsi = $s->deskripsi ?? ''; $this->link = $s->link ?? '';
        $this->tombol_teks = $s->tombol_teks ?? 'Selengkapnya'; $this->urutan = $s->urutan; $this->is_active = $s->is_active;
        $this->showForm = true;
    }

    public function save(): void
    {
        $this->validate();
        $data = ['judul' => $this->judul, 'deskripsi' => $this->deskripsi ?: null, 'link' => $this->link ?: null, 'tombol_teks' => $this->tombol_teks ?: null, 'urutan' => $this->urutan, 'is_active' => $this->is_active];
        if ($this->newGambar) { $data['gambar'] = $this->newGambar->store('sliders', 'public'); }

        if ($this->isEditing) { Slider::findOrFail($this->editId)->update($data); session()->flash('success', 'Slider diperbarui.'); }
        else { Slider::create($data); session()->flash('success', 'Slider ditambahkan.'); }
        $this->showForm = false;
    }

    public function confirmDelete(int $id): void { $this->deleteId = $id; $this->showDeleteConfirm = true; }
    public function delete(): void { if ($this->deleteId) { Slider::findOrFail($this->deleteId)->delete(); session()->flash('success', 'Slider dihapus.'); } $this->showDeleteConfirm = false; }
    public function toggleActive(int $id): void { $s = Slider::findOrFail($id); $s->update(['is_active' => !$s->is_active]); }

    public function render() { return view('livewire.admin.slider-manager', ['items' => Slider::ordered()->get()]); }
}
