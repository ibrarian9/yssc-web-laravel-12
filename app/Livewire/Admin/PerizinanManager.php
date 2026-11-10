<?php

namespace App\Livewire\Admin;

use App\Models\Perizinan;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class PerizinanManager extends Component
{
    use WithPagination, WithFileUploads;

    public string $search = '';
    public string $statusFilter = '';

    // Detail modal
    public bool $showDetail = false;
    public ?int $detailId = null;
    public string $newStatus = '';
    public string $catatanAdmin = '';

    // Form Modal (Tambah / Edit)
    public bool $showFormModal = false;
    public bool $isEditing = false;
    public ?int $editId = null;

    // Form fields
    public string $nama_pemohon = '';
    public string $email_pemohon = '';
    public string $phone_pemohon = '';
    public string $jenis_izin = 'kegiatan';
    public string $judul_permohonan = '';
    public string $deskripsi = '';
    public string $status = 'pending';
    public ?string $tanggal_permohonan = null;
    public string $formCatatanAdmin = '';
    public $dokumen_files = [];
    public array $existingDocuments = [];

    // Delete modal
    public bool $showDeleteConfirm = false;
    public ?int $deleteId = null;

    public function updatingSearch(): void { $this->resetPage(); }
    public function updatingStatusFilter(): void { $this->resetPage(); }

    protected function rules(): array
    {
        return [
            'nama_pemohon' => 'required|string|max:255',
            'email_pemohon' => 'required|email|max:255',
            'phone_pemohon' => 'nullable|string|max:25',
            'jenis_izin' => 'required|in:kegiatan,kerjasama,rekomendasi,lainnya',
            'judul_permohonan' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'status' => 'required|in:pending,diproses,selesai,ditolak',
            'tanggal_permohonan' => 'required|date',
            'formCatatanAdmin' => 'nullable|string',
            'dokumen_files.*' => 'nullable|file|mimes:pdf,jpg,jpeg,png,doc,docx|max:5120',
        ];
    }

    protected array $messages = [
        'nama_pemohon.required' => 'Nama pemohon wajib diisi.',
        'email_pemohon.required' => 'Email pemohon wajib diisi.',
        'email_pemohon.email' => 'Format email pemohon tidak valid.',
        'jenis_izin.required' => 'Pilih jenis izin / permohonan.',
        'judul_permohonan.required' => 'Judul permohonan wajib diisi.',
        'deskripsi.required' => 'Deskripsi permohonan wajib diisi.',
        'tanggal_permohonan.required' => 'Tanggal permohonan wajib diisi.',
        'dokumen_files.*.max' => 'Ukuran setiap dokumen pendukung maksimal 5MB.',
        'dokumen_files.*.mimes' => 'Format file dokumen harus PDF, JPG, PNG, atau DOC/DOCX.',
    ];

    public function create(): void
    {
        $this->reset([
            'editId', 'isEditing', 'nama_pemohon', 'email_pemohon',
            'phone_pemohon', 'judul_permohonan', 'deskripsi',
            'formCatatanAdmin', 'dokumen_files', 'existingDocuments'
        ]);
        $this->jenis_izin = 'kegiatan';
        $this->status = 'pending';
        $this->tanggal_permohonan = now()->format('Y-m-d');
        $this->resetErrorBag();
        $this->showFormModal = true;
    }

    public function edit(int $id): void
    {
        $p = Perizinan::findOrFail($id);
        $this->editId = $id;
        $this->isEditing = true;
        $this->nama_pemohon = $p->nama_pemohon;
        $this->email_pemohon = $p->email_pemohon;
        $this->phone_pemohon = $p->phone_pemohon ?? '';
        $this->jenis_izin = $p->jenis_izin ?? 'kegiatan';
        $this->judul_permohonan = $p->judul_permohonan;
        $this->deskripsi = $p->deskripsi;
        $this->status = $p->status;
        $this->tanggal_permohonan = $p->tanggal_permohonan ? $p->tanggal_permohonan->format('Y-m-d') : now()->format('Y-m-d');
        $this->formCatatanAdmin = $p->catatan_admin ?? '';
        $this->existingDocuments = $p->dokumen_pendukung ?? [];
        $this->dokumen_files = [];

        $this->resetErrorBag();
        $this->showFormModal = true;
    }

    public function removeExistingDoc(int $index): void
    {
        if (isset($this->existingDocuments[$index])) {
            $path = $this->existingDocuments[$index];
            Storage::disk('local')->delete($path);
            Storage::disk('public')->delete($path);
            unset($this->existingDocuments[$index]);
            $this->existingDocuments = array_values($this->existingDocuments);
        }
    }

    public function save(): void
    {
        $this->validate();

        $docs = $this->existingDocuments;

        if (!empty($this->dokumen_files)) {
            foreach ($this->dokumen_files as $file) {
                $path = $file->store('perizinan', 'local');
                $docs[] = $path;
            }
        }

        $data = [
            'nama_pemohon' => $this->nama_pemohon,
            'email_pemohon' => $this->email_pemohon,
            'phone_pemohon' => $this->phone_pemohon ?: null,
            'jenis_izin' => $this->jenis_izin,
            'judul_permohonan' => $this->judul_permohonan,
            'deskripsi' => $this->deskripsi,
            'status' => $this->status,
            'tanggal_permohonan' => $this->tanggal_permohonan,
            'catatan_admin' => $this->formCatatanAdmin ?: null,
            'dokumen_pendukung' => !empty($docs) ? $docs : null,
        ];

        if (in_array($this->status, ['diproses', 'selesai', 'ditolak'])) {
            $data['tanggal_proses'] = now();
            $data['processed_by'] = auth()->id();
        }

        if ($this->isEditing) {
            $p = Perizinan::findOrFail($this->editId);
            $p->update($data);
            session()->flash('success', "Permohonan perizinan \"{$p->judul_permohonan}\" berhasil diperbarui.");
        } else {
            $data['user_id'] = auth()->id();
            $p = Perizinan::create($data);
            session()->flash('success', "Permohonan perizinan \"{$p->judul_permohonan}\" berhasil ditambahkan.");
        }

        $this->showFormModal = false;
        $this->reset([
            'editId', 'isEditing', 'nama_pemohon', 'email_pemohon',
            'phone_pemohon', 'judul_permohonan', 'deskripsi',
            'formCatatanAdmin', 'dokumen_files', 'existingDocuments'
        ]);
    }

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
        session()->flash('success', 'Status perizinan berhasil diperbarui.');
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
            if ($p->dokumen_pendukung) {
                foreach ($p->dokumen_pendukung as $doc) {
                    Storage::disk('local')->delete($doc);
                    Storage::disk('public')->delete($doc);
                }
            }
            $p->delete();
            session()->flash('success', 'Permohonan perizinan berhasil dihapus.');
        }
        $this->showDeleteConfirm = false;
        $this->deleteId = null;
        $this->showDetail = false;
    }

    public function render()
    {
        $query = Perizinan::with('user');

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('nama_pemohon', 'like', "%{$this->search}%")
                  ->orWhere('email_pemohon', 'like', "%{$this->search}%")
                  ->orWhere('judul_permohonan', 'like', "%{$this->search}%")
                  ->orWhere('phone_pemohon', 'like', "%{$this->search}%");
            });
        }

        if ($this->statusFilter) {
            $query->where('status', $this->statusFilter);
        }

        $detail = $this->detailId ? Perizinan::with('user', 'processor')->find($this->detailId) : null;

        return view('livewire.admin.perizinan-manager', [
            'items' => $query->latest()->paginate(15),
            'detail' => $detail,
        ]);
    }
}
