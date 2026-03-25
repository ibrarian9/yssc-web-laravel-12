<?php

namespace App\Livewire\Admin;

use App\Models\Perizinan;
use Livewire\Component;
use Livewire\WithPagination;

class PerizinanManager extends Component
{
    use WithPagination;

    public string $search = '';
    public string $statusFilter = '';
    public bool $showDetail = false;
    public ?int $detailId = null;
    public string $newStatus = '';
    public string $catatanAdmin = '';
    public bool $showDeleteConfirm = false;
    public ?int $deleteId = null;

    public function updatingSearch(): void { $this->resetPage(); }

    public function openDetail(int $id): void
    {
        $p = Perizinan::findOrFail($id);
        $this->detailId = $id;
        $this->newStatus = $p->status;
        $this->catatanAdmin = $p->catatan_admin ?? '';
        $this->showDetail = true;
    }

    public function updateStatus(): void
    {
        $p = Perizinan::findOrFail($this->detailId);
        $p->update([
            'status' => $this->newStatus,
            'catatan_admin' => $this->catatanAdmin ?: null,
            'processed_by' => auth()->id(),
            'tanggal_proses' => now(),
        ]);
        session()->flash('success', 'Status perizinan diperbarui.');
        $this->showDetail = false;
    }

    public function confirmDelete(int $id): void
    {
        $this->deleteId = $id;
        $this->showDeleteConfirm = true;
    }

    public function deletePerizinan(): void
    {
        if ($this->deleteId) {
            $p = Perizinan::findOrFail($this->deleteId);
            // Clean up files
            if ($p->dokumen_pendukung) {
                foreach ($p->dokumen_pendukung as $doc) {
                    \Illuminate\Support\Facades\Storage::disk('local')->delete($doc);
                    \Illuminate\Support\Facades\Storage::disk('public')->delete($doc);
                }
            }
            $p->delete();
            session()->flash('success', 'Permohonan berhasil dihapus.');
        }
        $this->showDeleteConfirm = false;
        $this->deleteId = null;
    }

    public function render()
    {
        $query = Perizinan::with('user');
        if ($this->search) { $query->where(fn($q) => $q->where('nama_pemohon', 'like', "%{$this->search}%")->orWhere('judul_permohonan', 'like', "%{$this->search}%")); }
        if ($this->statusFilter) { $query->where('status', $this->statusFilter); }
        return view('livewire.admin.perizinan-manager', ['items' => $query->latest()->paginate(15)]);
    }
}
