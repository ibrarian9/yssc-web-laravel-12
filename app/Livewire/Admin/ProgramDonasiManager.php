<?php

namespace App\Livewire\Admin;

use App\Models\Profile;
use App\Models\ProgramDonasi;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Str;

class ProgramDonasiManager extends Component
{
    use WithPagination, WithFileUploads;

    public string $search = '';
    public string $statusFilter = '';
    public bool $isMenuDonasiActive = true;

    public bool $showForm = false;
    public bool $isEditing = false;
    public ?int $editId = null;

    public string $judul = '';
    public string $deskripsi = '';
    public float $target_nominal = 0;
    public string $status = 'aktif';
    public bool $is_mendesak = false;
    public ?string $tanggal_mulai = '';
    public ?string $tanggal_selesai = '';
    public $newThumbnail;

    public bool $showDeleteConfirm = false;
    public ?int $deleteId = null;

    protected function rules(): array
    {
        return [
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'target_nominal' => 'required|numeric|min:100000',
            'status' => 'required|in:draft,aktif,selesai',
            'tanggal_mulai' => 'nullable|date',
            'tanggal_selesai' => 'nullable|date',
            'newThumbnail' => 'nullable|image|max:2048',
        ];
    }

    public function mount(): void
    {
        $profile = Profile::first();
        $this->isMenuDonasiActive = (bool) ($profile?->is_donasi_enabled ?? true);
    }

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingStatusFilter(): void
    {
        $this->resetPage();
    }

    public function toggleMenuDonasi(): void
    {
        $profile = Profile::first();
        if (!$profile) {
            $profile = Profile::create([
                'nama_organisasi' => 'Yayasan Seribu Satu Cita',
                'is_donasi_enabled' => true,
            ]);
        }

        $newState = !((bool) ($profile->is_donasi_enabled ?? true));
        $profile->update(['is_donasi_enabled' => $newState]);
        $this->isMenuDonasiActive = $newState;

        $msg = $newState
            ? 'Menu donasi di website publik berhasil DIAKTIFKAN.'
            : 'Menu donasi di website publik berhasil DINONAKTIFKAN.';
        session()->flash('success', $msg);
    }

    public function toggleStatus(int $id): void
    {
        $program = ProgramDonasi::findOrFail($id);
        $newStatus = ($program->status === 'aktif') ? 'draft' : 'aktif';
        $program->update(['status' => $newStatus]);

        $label = ($newStatus === 'aktif') ? 'diaktifkan' : 'dinonaktifkan (draft)';
        session()->flash('success', "Program \"{$program->judul}\" berhasil {$label}.");
    }

    public function create(): void
    {
        $this->reset([
            'judul',
            'deskripsi',
            'target_nominal',
            'status',
            'is_mendesak',
            'tanggal_mulai',
            'tanggal_selesai',
            'newThumbnail',
            'editId',
            'isEditing'
        ]);
        $this->status = 'aktif';
        $this->tanggal_mulai = now()->toDateString();
        $this->showForm = true;
    }

    public function edit(int $id): void
    {
        $p = ProgramDonasi::findOrFail($id);
        $this->editId = $id;
        $this->isEditing = true;
        $this->judul = $p->judul;
        $this->deskripsi = $p->deskripsi;
        $this->target_nominal = (float) $p->target_nominal;
        $this->status = $p->status;
        $this->is_mendesak = (bool) $p->is_mendesak;
        $this->tanggal_mulai = $p->tanggal_mulai?->format('Y-m-d') ?? '';
        $this->tanggal_selesai = $p->tanggal_selesai?->format('Y-m-d') ?? '';
        $this->showForm = true;
    }

    public function save(): void
    {
        $this->validate();

        $data = [
            'judul' => $this->judul,
            'slug' => Str::slug($this->judul),
            'deskripsi' => $this->deskripsi,
            'target_nominal' => $this->target_nominal,
            'status' => $this->status,
            'is_mendesak' => $this->is_mendesak,
            'tanggal_mulai' => $this->tanggal_mulai ?: now()->toDateString(),
            'tanggal_selesai' => $this->tanggal_selesai ?: null,
        ];

        if ($this->newThumbnail) {
            $data['thumbnail'] = $this->newThumbnail->store('program-donasi', 'public');
        }

        if ($this->isEditing) {
            ProgramDonasi::findOrFail($this->editId)->update($data);
            session()->flash('success', 'Program donasi berhasil diperbarui.');
        } else {
            ProgramDonasi::create($data);
            session()->flash('success', 'Program donasi baru berhasil ditambahkan.');
        }

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
            ProgramDonasi::findOrFail($this->deleteId)->delete();
            session()->flash('success', 'Program donasi berhasil dihapus.');
        }
        $this->showDeleteConfirm = false;
    }

    public function render()
    {
        $query = ProgramDonasi::withCount('donasi')
            ->withSum(['donasi as total_donasi' => fn($q) => $q->where('status_pembayaran', 'success')], 'nominal');

        if ($this->search) {
            $query->where('judul', 'like', "%{$this->search}%");
        }

        if ($this->statusFilter) {
            $query->where('status', $this->statusFilter);
        }

        return view('livewire.admin.program-donasi-manager', [
            'items' => $query->latest()->paginate(10),
            'totalActive' => ProgramDonasi::where('status', 'aktif')->count(),
            'totalDraft' => ProgramDonasi::where('status', 'draft')->count(),
            'totalSelesai' => ProgramDonasi::where('status', 'selesai')->count(),
        ]);
    }
}
