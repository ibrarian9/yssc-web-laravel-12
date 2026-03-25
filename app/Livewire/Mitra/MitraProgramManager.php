<?php

namespace App\Livewire\Mitra;

use App\Models\Mitra;
use App\Models\ProgramDonasi;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class MitraProgramManager extends Component
{
    use WithPagination, WithFileUploads;

    public bool $showForm = false;
    public ?int $editId = null;
    public string $judul = '';
    public string $deskripsi = '';
    public $thumbnail;
    public string $targetNominal = '';
    public string $tanggalSelesai = '';
    public string $status = 'aktif';

    protected function rules()
    {
        return [
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'targetNominal' => 'required|numeric|min:100000',
            'tanggalSelesai' => 'nullable|date|after:today',
            'thumbnail' => $this->editId ? 'nullable|image|max:2048' : 'required|image|max:2048',
        ];
    }

    public function create(): void
    {
        $this->reset(['editId', 'judul', 'deskripsi', 'thumbnail', 'targetNominal', 'tanggalSelesai', 'status']);
        $this->status = 'aktif';
        $this->showForm = true;
    }

    public function edit(int $id): void
    {
        $program = $this->getOwnProgram($id);
        if (!$program) return;

        $this->editId = $program->id;
        $this->judul = $program->judul;
        $this->deskripsi = $program->deskripsi;
        $this->targetNominal = $program->target_nominal;
        $this->tanggalSelesai = $program->tanggal_selesai?->format('Y-m-d') ?? '';
        $this->status = $program->status;
        $this->showForm = true;
    }

    public function save(): void
    {
        $this->validate();

        $mitra = $this->getMitra();
        $data = [
            'judul' => $this->judul,
            'slug' => Str::slug($this->judul) . '-' . time(),
            'deskripsi' => $this->deskripsi,
            'target_nominal' => $this->targetNominal,
            'tanggal_mulai' => now(),
            'tanggal_selesai' => $this->tanggalSelesai ?: null,
            'status' => $this->status,
            'mitra_id' => $mitra->id,
        ];

        if ($this->thumbnail) {
            $data['thumbnail'] = $this->thumbnail->store('program-donasi', 'public');
        }

        if ($this->editId) {
            $program = $this->getOwnProgram($this->editId);
            $program?->update($data);
            session()->flash('success', 'Program berhasil diperbarui.');
        } else {
            ProgramDonasi::create($data);
            session()->flash('success', 'Program berhasil dibuat.');
        }

        $this->showForm = false;
        $this->reset(['editId', 'judul', 'deskripsi', 'thumbnail', 'targetNominal', 'tanggalSelesai']);
    }

    public function toggleStatus(int $id): void
    {
        $program = $this->getOwnProgram($id);
        if ($program) {
            $program->update(['status' => $program->status === 'aktif' ? 'selesai' : 'aktif']);
        }
    }

    private function getMitra(): ?Mitra
    {
        return Mitra::where('user_id', auth()->id())->first();
    }

    private function getOwnProgram(int $id): ?ProgramDonasi
    {
        $mitra = $this->getMitra();
        return $mitra ? ProgramDonasi::where('id', $id)->where('mitra_id', $mitra->id)->first() : null;
    }

    public function render()
    {
        $mitra = $this->getMitra();
        $programs = ProgramDonasi::where('mitra_id', $mitra?->id)
            ->latest()
            ->paginate(10);

        return view('livewire.mitra.mitra-program-manager', compact('programs'));
    }
}
