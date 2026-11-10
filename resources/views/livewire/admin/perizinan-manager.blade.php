<div>
    {{-- Alerts --}}
    @if(session('success'))
        <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-xl flex items-center gap-3 text-sm font-medium text-green-700">
            <span class="material-symbols-outlined text-[20px]!">check_circle</span>
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-xl flex items-center gap-3 text-sm font-medium text-red-700">
            <span class="material-symbols-outlined text-[20px]!">error</span>
            {{ session('error') }}
        </div>
    @endif

    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
        <div>
            <h2 class="text-2xl font-extrabold text-gray-800">Manajemen Perizinan</h2>
            <p class="text-sm text-gray-500">Kelola permohonan izin kegiatan, kerja sama, dan surat rekomendasi</p>
        </div>
        <button wire:click="create"
            class="inline-flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-teal-600 to-teal-700 hover:from-teal-700 hover:to-teal-800 text-white font-bold text-sm rounded-xl shadow-lg shadow-teal-500/20 transition cursor-pointer">
            <span class="material-symbols-outlined text-[18px]!">post_add</span>
            Tambah Perizinan
        </button>
    </div>

    {{-- Filters --}}
    <div class="bg-white rounded-2xl p-5 shadow-md border border-gray-100 mb-8 flex flex-col lg:flex-row gap-4 items-stretch">
        <div class="flex-1 relative">
            <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-[20px]!">search</span>
            <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari nama pemohon, email, judul permohonan..."
                class="w-full pl-12 pr-4 py-3 border border-gray-200 rounded-xl text-base focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-all duration-200 bg-gray-50/30 focus:bg-white">
        </div>
        <div class="flex flex-col sm:flex-row gap-3">
            <select wire:model.live="statusFilter"
                class="min-w-[160px] px-4 py-3 border border-gray-200 rounded-xl text-sm font-medium text-gray-600 focus:ring-2 focus:ring-teal-500 bg-white cursor-pointer hover:border-teal-300 transition-colors">
                <option value="">Semua Status</option>
                <option value="pending">Pending</option>
                <option value="diproses">Diproses</option>
                <option value="selesai">Selesai</option>
                <option value="ditolak">Ditolak</option>
            </select>
        </div>
    </div>

    {{-- Table --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 border-b border-gray-100">
                    <tr class="text-left text-xs text-gray-500 uppercase tracking-wider">
                        <th class="px-4 py-3">Pemohon</th>
                        <th class="px-4 py-3">Jenis Izin</th>
                        <th class="px-4 py-3">Judul Permohonan</th>
                        <th class="px-4 py-3 text-center">Dokumen</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3">Tanggal</th>
                        <th class="px-4 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($items as $item)
                        @php
                            $statusBadge = match($item->status) {
                                'pending' => 'bg-amber-100 text-amber-700 border-amber-200',
                                'diproses' => 'bg-blue-100 text-blue-700 border-blue-200',
                                'selesai' => 'bg-green-100 text-green-700 border-green-200',
                                'ditolak' => 'bg-red-100 text-red-700 border-red-200',
                                default => 'bg-gray-100 text-gray-600 border-gray-200',
                            };
                            $jenisLabel = match($item->jenis_izin) {
                                'kegiatan' => 'Kegiatan',
                                'kerjasama' => 'Kerja Sama',
                                'rekomendasi' => 'Rekomendasi',
                                default => 'Lainnya',
                            };
                        @endphp
                        <tr class="hover:bg-gray-50/50 transition">
                            <td class="px-4 py-3">
                                <p class="font-semibold text-gray-800">{{ $item->nama_pemohon }}</p>
                                <p class="text-xs text-gray-400">{{ $item->email_pemohon }}</p>
                                @if($item->phone_pemohon)
                                    <p class="text-[11px] text-gray-400">{{ $item->phone_pemohon }}</p>
                                @endif
                            </td>
                            <td class="px-4 py-3">
                                <span class="px-2.5 py-0.5 rounded-full text-xs font-semibold bg-gray-100 text-gray-700">
                                    {{ $jenisLabel }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-gray-700 font-medium max-w-[220px] truncate" title="{{ $item->judul_permohonan }}">
                                {{ $item->judul_permohonan }}
                            </td>
                            <td class="px-4 py-3 text-center">
                                @if($item->dokumen_pendukung && count($item->dokumen_pendukung) > 0)
                                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-bold bg-teal-50 text-teal-700 border border-teal-200">
                                        <span class="material-symbols-outlined text-[14px]!">attach_file</span>
                                        {{ count($item->dokumen_pendukung) }}
                                    </span>
                                @else
                                    <span class="text-xs text-gray-300">—</span>
                                @endif
                            </td>
                            @php
                                $statusIcon = match($item->status) {
                                    'pending' => 'schedule',
                                    'diproses' => 'sync',
                                    'selesai' => 'check_circle',
                                    'ditolak' => 'cancel',
                                    default => 'help_outline',
                                };
                            @endphp
                            <td class="px-4 py-3">
                                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-bold capitalize border {{ $statusBadge }}">
                                    <span class="material-symbols-outlined text-[13px]!">{{ $statusIcon }}</span>
                                    {{ $item->status }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-gray-400 text-xs whitespace-nowrap">
                                {{ $item->tanggal_permohonan->format('d/m/Y') }}
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex justify-end gap-1">
                                    <button wire:click="openDetail({{ $item->id }})" class="p-1.5 rounded-lg hover:bg-teal-50 text-teal-600 transition" title="Lihat Detail & Status">
                                        <span class="material-symbols-outlined text-[18px]!">visibility</span>
                                    </button>
                                    <button wire:click="edit({{ $item->id }})" class="p-1.5 rounded-lg hover:bg-blue-50 text-blue-600 transition" title="Edit Permohonan">
                                        <span class="material-symbols-outlined text-[18px]!">edit</span>
                                    </button>
                                    <button wire:click="confirmDelete({{ $item->id }})" class="p-1.5 rounded-lg hover:bg-red-50 text-red-500 transition" title="Hapus Permohonan">
                                        <span class="material-symbols-outlined text-[18px]!">delete</span>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-4 py-12 text-center text-gray-400">
                                <span class="material-symbols-outlined text-4xl mb-2 text-gray-300">description</span>
                                <p class="text-sm">Tidak ada permohonan perizinan ditemukan.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($items->hasPages())
            <div class="p-4 border-t border-gray-100">{{ $items->links() }}</div>
        @endif
    </div>

    {{-- Form Modal (Tambah / Edit Perizinan) --}}
    @if($showFormModal)
    <div class="fixed inset-0 z-50 flex items-center justify-center p-4">
        <div class="fixed inset-0 bg-black/50 backdrop-blur-sm" wire:click="$set('showFormModal', false)"></div>
        <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-2xl overflow-hidden animate-in fade-in duration-200">
            <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100 bg-gray-50/50">
                <div class="flex items-center gap-2">
                    <span class="material-symbols-outlined text-teal-600">{{ $isEditing ? 'edit_document' : 'post_add' }}</span>
                    <h3 class="text-lg font-bold text-gray-800">{{ $isEditing ? 'Edit Data Perizinan' : 'Tambah Permohonan Perizinan' }}</h3>
                </div>
                <button wire:click="$set('showFormModal', false)" class="p-1 rounded-lg hover:bg-gray-200 text-gray-400">
                    <span class="material-symbols-outlined text-[20px]!">close</span>
                </button>
            </div>

            <form wire:submit="save" class="p-6 space-y-4 max-h-[80vh] overflow-y-auto">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Nama Pemohon *</label>
                        <input type="text" wire:model="nama_pemohon" placeholder="Nama lengkap atau penanggung jawab"
                            class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-teal-500">
                        @error('nama_pemohon') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Email Pemohon *</label>
                        <input type="email" wire:model="email_pemohon" placeholder="email@pemohon.com"
                            class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-teal-500">
                        @error('email_pemohon') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Nomor WhatsApp/HP</label>
                        <input type="text" wire:model="phone_pemohon" placeholder="08xxxxxxxxxx"
                            class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-teal-500">
                        @error('phone_pemohon') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Jenis Permohonan *</label>
                        <select wire:model="jenis_izin" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-teal-500 bg-white">
                            <option value="kegiatan">Izin Kegiatan</option>
                            <option value="kerjasama">Kerja Sama</option>
                            <option value="rekomendasi">Surat Rekomendasi</option>
                            <option value="lainnya">Lainnya</option>
                        </select>
                        @error('jenis_izin') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Tanggal Permohonan *</label>
                        <input type="date" wire:model="tanggal_permohonan"
                            class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-teal-500">
                        @error('tanggal_permohonan') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Judul Permohonan *</label>
                    <input type="text" wire:model="judul_permohonan" placeholder="cth: Permohonan Izin Tempat Kegiatan Seminar Anak"
                        class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-teal-500">
                    @error('judul_permohonan') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Deskripsi Lengkap *</label>
                    <textarea wire:model="deskripsi" rows="3" placeholder="Jelaskan maksud dan rincian permohonan..."
                        class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-teal-500 resize-none"></textarea>
                    @error('deskripsi') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Dokumen Pendukung --}}
                <div class="p-4 bg-gray-50 rounded-xl border border-gray-100 space-y-3">
                    <label class="block text-xs font-bold uppercase tracking-wider text-gray-600">Dokumen Pendukung (Proposal / Surat Pengantar)</label>

                    @if(!empty($existingDocuments))
                        <div class="space-y-1.5 mb-2">
                            <p class="text-xs text-gray-500 font-medium">Dokumen yang sudah diunggah:</p>
                            @foreach($existingDocuments as $idx => $doc)
                                <div class="flex items-center justify-between p-2 bg-white rounded-lg border border-gray-200 text-xs">
                                    <span class="flex items-center gap-1.5 text-gray-700 font-medium truncate">
                                        <span class="material-symbols-outlined text-[16px]! text-teal-600">attachment</span>
                                        Dokumen {{ $idx + 1 }} ({{ pathinfo($doc, PATHINFO_BASENAME) }})
                                    </span>
                                    <button type="button" wire:click="removeExistingDoc({{ $idx }})" class="text-red-500 hover:text-red-700 p-1" title="Hapus file ini">
                                        <span class="material-symbols-outlined text-[16px]!">close</span>
                                    </button>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    <input type="file" wire:model="dokumen_files" multiple class="w-full text-xs file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-teal-50 file:text-teal-700 file:font-semibold">
                    <p class="text-[11px] text-gray-400">Bisa memilih lebih dari 1 file (PDF, JPG, PNG, DOC/DOCX, maks 5MB per file).</p>
                    @error('dokumen_files.*') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Status Permohonan *</label>
                        <select wire:model="status" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-teal-500 bg-white">
                            <option value="pending">Pending (Menunggu)</option>
                            <option value="diproses">Diproses</option>
                            <option value="selesai">Selesai (Disetujui)</option>
                            <option value="ditolak">Ditolak</option>
                        </select>
                        @error('status') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Catatan Admin (Opsional)</label>
                        <input type="text" wire:model="formCatatanAdmin" placeholder="Catatan atau alasan persetujuan/penolakan..."
                            class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-teal-500">
                    </div>
                </div>

                <div class="flex justify-end gap-3 pt-4 border-t border-gray-100">
                    <button type="button" wire:click="$set('showFormModal', false)"
                        class="px-5 py-2.5 border border-gray-200 text-gray-600 font-semibold rounded-xl text-sm hover:bg-gray-50 transition">
                        Batal
                    </button>
                    <button type="submit"
                        class="px-5 py-2.5 bg-teal-600 hover:bg-teal-700 text-white font-bold rounded-xl text-sm shadow-md shadow-teal-500/20 transition cursor-pointer">
                        {{ $isEditing ? 'Simpan Perubahan' : 'Tambahkan Perizinan' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endif

    {{-- Detail Modal --}}
    @if($showDetail && $detail)
    <div class="fixed inset-0 z-50 flex items-center justify-center p-4">
        <div class="fixed inset-0 bg-black/50 backdrop-blur-sm" wire:click="$set('showDetail', false)"></div>
        <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-xl max-h-[90vh] overflow-y-auto animate-in fade-in duration-200">
            <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100 bg-gray-50/50">
                <div class="flex items-center gap-2">
                    <span class="material-symbols-outlined text-teal-600">article</span>
                    <h3 class="text-lg font-bold text-gray-800">Detail Permohonan #{{ $detail->id }}</h3>
                </div>
                <button wire:click="$set('showDetail', false)" class="p-1 rounded-lg hover:bg-gray-200 text-gray-400">
                    <span class="material-symbols-outlined text-[20px]!">close</span>
                </button>
            </div>

            <div class="p-6 space-y-5">
                <div>
                    <h4 class="text-base font-bold text-gray-800 mb-1">{{ $detail->judul_permohonan }}</h4>
                    <div class="flex flex-wrap items-center gap-2">
                        <span class="px-2.5 py-0.5 rounded-full text-xs font-semibold bg-gray-100 text-gray-700 capitalize">{{ $detail->jenis_izin }}</span>
                        <span class="text-xs text-gray-400">Diajukan: {{ $detail->tanggal_permohonan->format('d M Y') }}</span>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-3 text-xs bg-gray-50 rounded-xl p-3 border border-gray-100">
                    <div>
                        <p class="text-gray-400 uppercase font-bold text-[10px]">Pemohon</p>
                        <p class="font-semibold text-gray-800">{{ $detail->nama_pemohon }}</p>
                        <p class="text-gray-500">{{ $detail->email_pemohon }}</p>
                    </div>
                    <div>
                        <p class="text-gray-400 uppercase font-bold text-[10px]">Kontak Telepon</p>
                        <p class="font-semibold text-gray-800">{{ $detail->phone_pemohon ?: '—' }}</p>
                    </div>
                    <div>
                        <p class="text-gray-400 uppercase font-bold text-[10px]">Status Saat Ini</p>
                        <span class="font-bold uppercase text-[10px] text-teal-700">{{ $detail->status }}</span>
                    </div>
                    <div>
                        <p class="text-gray-400 uppercase font-bold text-[10px]">Diproses Oleh</p>
                        <p class="text-gray-700">{{ $detail->processor?->name ?? '—' }}</p>
                    </div>
                </div>

                <div>
                    <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Deskripsi Permohonan</p>
                    <div class="text-sm text-gray-700 bg-gray-50 rounded-xl p-3 leading-relaxed whitespace-pre-line">{{ $detail->deskripsi }}</div>
                </div>

                {{-- Dokumen --}}
                <div>
                    <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Dokumen Terlampir</p>
                    @if($detail->dokumen_pendukung && count($detail->dokumen_pendukung) > 0)
                        <div class="space-y-2">
                            @foreach($detail->dokumen_pendukung as $idx => $path)
                                @php
                                    $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));
                                    $icon = match($ext) {
                                        'pdf' => 'picture_as_pdf',
                                        'jpg', 'jpeg', 'png' => 'image',
                                        default => 'description',
                                    };
                                @endphp
                                <a href="{{ route('admin.perizinan.dokumen', [$detail->id, $idx]) }}" target="_blank"
                                    class="flex items-center justify-between p-3 border border-gray-200 rounded-xl hover:bg-gray-50 text-sm text-teal-700 font-medium transition">
                                    <span class="flex items-center gap-2">
                                        <span class="material-symbols-outlined text-[18px]! text-teal-600">{{ $icon }}</span>
                                        Dokumen {{ $idx + 1 }} (.{{ $ext }})
                                    </span>
                                    <span class="material-symbols-outlined text-[18px]! text-gray-400">download</span>
                                </a>
                            @endforeach
                        </div>
                    @else
                        <p class="text-xs text-gray-400 italic bg-gray-50 p-3 rounded-xl">Tidak ada dokumen pendukung.</p>
                    @endif
                </div>

                <hr class="border-gray-100">

                {{-- Quick Status Update --}}
                <div class="space-y-3 bg-gray-50 p-4 rounded-xl border border-gray-100">
                    <p class="text-xs font-bold uppercase tracking-wider text-gray-600">Update Status & Catatan Cepat</p>
                    <div>
                        <select wire:model="newStatus" class="w-full px-4 py-2 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-teal-500 bg-white">
                            <option value="pending">Pending</option>
                            <option value="diproses">Diproses</option>
                            <option value="selesai">Selesai</option>
                            <option value="ditolak">Ditolak</option>
                        </select>
                    </div>
                    <div>
                        <textarea wire:model="catatanAdmin" rows="2" placeholder="Catatan untuk pemohon..."
                            class="w-full px-4 py-2 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-teal-500 resize-none bg-white"></textarea>
                    </div>
                    <button wire:click="updateStatus" class="w-full py-2.5 bg-teal-600 hover:bg-teal-700 text-white font-bold rounded-xl text-sm transition">
                        Perbarui Status
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif

    {{-- Delete Confirm Modal --}}
    @if($showDeleteConfirm)
    <div class="fixed inset-0 z-50 flex items-center justify-center p-4">
        <div class="fixed inset-0 bg-black/50 backdrop-blur-sm" wire:click="$set('showDeleteConfirm', false)"></div>
        <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-sm p-6 text-center animate-in fade-in duration-200">
            <div class="w-12 h-12 bg-red-100 text-red-600 rounded-full flex items-center justify-center mx-auto mb-4">
                <span class="material-symbols-outlined text-2xl">warning</span>
            </div>
            <h4 class="text-lg font-bold text-gray-800 mb-2">Hapus Permohonan?</h4>
            <p class="text-sm text-gray-500 mb-6">Permohonan perizinan dan dokumen terlampir akan dihapus dari sistem.</p>
            <div class="flex justify-center gap-3">
                <button type="button" wire:click="$set('showDeleteConfirm', false)"
                    class="px-4 py-2 border border-gray-200 text-gray-600 font-medium rounded-xl text-sm hover:bg-gray-50 transition">
                    Batal
                </button>
                <button type="button" wire:click="deletePerizinan"
                    class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-bold rounded-xl text-sm shadow-md shadow-red-500/20 transition">
                    Ya, Hapus
                </button>
            </div>
        </div>
    </div>
    @endif
</div>
