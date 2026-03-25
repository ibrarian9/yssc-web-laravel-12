<?php

namespace App\Livewire\Admin;

use App\Models\AnggotaDevisi;
use App\Models\Divisi;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class AnggotaManager extends Component
{
    use WithPagination, WithFileUploads;

    public string $search = '';
    public string $filterDivisi = '';
    public string $activeTab = 'anggota'; // anggota | divisi

    // Anggota form
    public bool $showAnggotaForm = false;
    public ?int $editAnggotaId = null;
    public string $nama = '';
    public string $jabatan = '';
    public string $bio = '';
    public string $email = '';
    public string $linkedin = '';
    public string $instagram = '';
    public string $divisiId = '';
    public $foto;
    public string $periodeMulai = '';
    public string $periodeSelesai = '';
    public bool $isActive = true;
    public int $urutan = 0;

    // Divisi form
    public bool $showDivisiForm = false;
    public ?int $editDivisiId = null;
    public string $namaDivisi = '';
    public string $deskripsiDivisi = '';
    public int $urutanDivisi = 0;
    public bool $isDivisiActive = true;

    public function updatingSearch(): void { $this->resetPage(); }
    public function updatingFilterDivisi(): void { $this->resetPage(); }

    // ── Anggota CRUD ──

    public function createAnggota(): void
    {
        $this->resetAnggotaForm();
        $this->showAnggotaForm = true;
    }

    public function editAnggota(int $id): void
    {
        $a = AnggotaDevisi::findOrFail($id);
        $this->editAnggotaId = $a->id;
        $this->nama = $a->nama;
        $this->jabatan = $a->jabatan;
        $this->bio = $a->bio ?? '';
        $this->email = $a->email ?? '';
        $this->linkedin = $a->linkedin ?? '';
        $this->instagram = $a->instagram ?? '';
        $this->divisiId = $a->divisi_id;
        $this->periodeMulai = $a->periode_mulai?->format('Y-m-d') ?? '';
        $this->periodeSelesai = $a->periode_selesai?->format('Y-m-d') ?? '';
        $this->isActive = $a->is_active;
        $this->urutan = $a->urutan ?? 0;
        $this->showAnggotaForm = true;
    }

    public function saveAnggota(): void
    {
        $rules = [
            'nama' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            'divisiId' => 'required|exists:divisi,id',
            'bio' => 'nullable|string',
            'email' => 'nullable|email|max:255',
            'linkedin' => 'nullable|string|max:255',
            'instagram' => 'nullable|string|max:255',
            'periodeMulai' => 'nullable|date',
            'periodeSelesai' => 'nullable|date',
            'foto' => $this->editAnggotaId ? 'nullable|image|max:2048' : 'nullable|image|max:2048',
        ];

        $this->validate($rules);

        $data = [
            'nama' => $this->nama,
            'jabatan' => $this->jabatan,
            'divisi_id' => $this->divisiId,
            'bio' => $this->bio ?: null,
            'email' => $this->email ?: null,
            'linkedin' => $this->linkedin ?: null,
            'instagram' => $this->instagram ?: null,
            'periode_mulai' => $this->periodeMulai ?: null,
            'periode_selesai' => $this->periodeSelesai ?: null,
            'is_active' => $this->isActive,
            'urutan' => $this->urutan,
        ];

        if ($this->foto) {
            $data['foto'] = $this->foto->store('anggota', 'public');
        }

        if ($this->editAnggotaId) {
            AnggotaDevisi::findOrFail($this->editAnggotaId)->update($data);
            session()->flash('success', 'Anggota berhasil diperbarui.');
        } else {
            AnggotaDevisi::create($data);
            session()->flash('success', 'Anggota berhasil ditambahkan.');
        }

        $this->showAnggotaForm = false;
        $this->resetAnggotaForm();
    }

    public function deleteAnggota(int $id): void
    {
        AnggotaDevisi::findOrFail($id)->delete();
        session()->flash('success', 'Anggota berhasil dihapus.');
    }

    public function toggleAnggota(int $id): void
    {
        $a = AnggotaDevisi::findOrFail($id);
        $a->update(['is_active' => !$a->is_active]);
    }

    private function resetAnggotaForm(): void
    {
        $this->reset(['editAnggotaId', 'nama', 'jabatan', 'bio', 'email', 'linkedin', 'instagram', 'divisiId', 'foto', 'periodeMulai', 'periodeSelesai']);
        $this->isActive = true;
        $this->urutan = 0;
    }

    // ── Divisi CRUD ──

    public function createDivisi(): void
    {
        $this->resetDivisiForm();
        $this->showDivisiForm = true;
    }

    public function editDivisi(int $id): void
    {
        $d = Divisi::findOrFail($id);
        $this->editDivisiId = $d->id;
        $this->namaDivisi = $d->nama;
        $this->deskripsiDivisi = $d->deskripsi ?? '';
        $this->urutanDivisi = $d->urutan ?? 0;
        $this->isDivisiActive = $d->is_active;
        $this->showDivisiForm = true;
    }

    public function saveDivisi(): void
    {
        $this->validate([
            'namaDivisi' => 'required|string|max:255',
            'deskripsiDivisi' => 'nullable|string',
        ]);

        $data = [
            'nama' => $this->namaDivisi,
            'deskripsi' => $this->deskripsiDivisi ?: null,
            'urutan' => $this->urutanDivisi,
            'is_active' => $this->isDivisiActive,
        ];

        if ($this->editDivisiId) {
            Divisi::findOrFail($this->editDivisiId)->update($data);
            session()->flash('success', 'Divisi berhasil diperbarui.');
        } else {
            Divisi::create($data);
            session()->flash('success', 'Divisi berhasil ditambahkan.');
        }

        $this->showDivisiForm = false;
        $this->resetDivisiForm();
    }

    public function deleteDivisi(int $id): void
    {
        $d = Divisi::findOrFail($id);
        if ($d->anggota()->count() > 0) {
            session()->flash('error', 'Tidak bisa menghapus divisi yang masih memiliki anggota.');
            return;
        }
        $d->delete();
        session()->flash('success', 'Divisi berhasil dihapus.');
    }

    private function resetDivisiForm(): void
    {
        $this->reset(['editDivisiId', 'namaDivisi', 'deskripsiDivisi']);
        $this->urutanDivisi = 0;
        $this->isDivisiActive = true;
    }

    public function render()
    {
        $anggotaQuery = AnggotaDevisi::with('divisi');
        if ($this->search) {
            $anggotaQuery->where(fn($q) => $q
                ->where('nama', 'like', "%{$this->search}%")
                ->orWhere('jabatan', 'like', "%{$this->search}%")
                ->orWhere('email', 'like', "%{$this->search}%")
            );
        }
        if ($this->filterDivisi) {
            $anggotaQuery->where('divisi_id', $this->filterDivisi);
        }

        return view('livewire.admin.anggota-manager', [
            'anggotaList' => $anggotaQuery->ordered()->paginate(15),
            'divisiList' => Divisi::ordered()->withCount('anggota')->get(),
            'divisiOptions' => Divisi::active()->ordered()->get(),
        ]);
    }
}
