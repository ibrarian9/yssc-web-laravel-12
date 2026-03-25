<?php

namespace App\Livewire\Admin;

use App\Models\Donasi;
use Livewire\Component;
use Livewire\WithPagination;

class TransaksiDonasiManager extends Component
{
    use WithPagination;

    public string $search = '';
    public string $filterStatus = '';
    public string $filterProgram = '';
    public bool $showDetail = false;
    public ?int $selectedId = null;

    public function updatingSearch() { $this->resetPage(); }
    public function updatingFilterStatus() { $this->resetPage(); }

    public function showDetail(int $id): void
    {
        $this->selectedId = $id;
        $this->showDetail = true;
    }

    public function closeDetail(): void
    {
        $this->showDetail = false;
        $this->selectedId = null;
    }

    public function render()
    {
        $donasi = Donasi::with(['program', 'user'])
            ->when($this->search, fn($q) => $q->where(fn($q2) =>
                $q2->where('nama_donatur', 'like', "%{$this->search}%")
                   ->orWhere('email_donatur', 'like', "%{$this->search}%")
                   ->orWhere('kode_unik', 'like', "%{$this->search}%")
                   ->orWhere('midtrans_order_id', 'like', "%{$this->search}%")
            ))
            ->when($this->filterStatus, fn($q) => $q->where('status_pembayaran', $this->filterStatus))
            ->latest()
            ->paginate(15);

        $selected = $this->selectedId ? Donasi::with(['program', 'user'])->find($this->selectedId) : null;

        return view('livewire.admin.transaksi-donasi-manager', compact('donasi', 'selected'));
    }
}
