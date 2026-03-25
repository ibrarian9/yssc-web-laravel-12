<div>
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
        <div>
            <h2 class="text-2xl font-extrabold text-gray-800">Manajemen Mitra</h2>
            <p class="text-sm text-gray-500">Kelola pendaftaran dan persetujuan mitra</p>
        </div>
        @if($pendingCount > 0)
            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-amber-100 text-amber-700 rounded-full text-xs font-bold">
                <span class="w-2 h-2 bg-amber-500 rounded-full animate-pulse"></span>
                {{ $pendingCount }} menunggu persetujuan
            </span>
        @endif
    </div>

    {{-- Filters --}}
    <div class="bg-white rounded-2xl p-5 shadow-md border border-gray-100 mb-8 flex flex-col lg:flex-row gap-4 items-stretch">
        <div class="flex-1 relative">
            <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-[20px]!">search</span>
            <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari nama perusahaan, email, NPWP..."
                class="w-full pl-12 pr-4 py-3 border border-gray-200 rounded-xl text-base focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-all duration-200 bg-gray-50/30 focus:bg-white">
        </div>
        <div class="flex flex-col sm:flex-row gap-3">
            <select wire:model.live="filterStatus"
                class="min-w-[140px] px-4 py-3 border border-gray-200 rounded-xl text-sm font-medium text-gray-600 focus:ring-2 focus:ring-teal-500 bg-white cursor-pointer hover:border-teal-300 transition-colors">
                <option value="">Semua Status</option>
                <option value="pending">Pending</option>
                <option value="approved">Approved</option>
                <option value="rejected">Rejected</option>
            </select>
        </div>
    </div>

    {{-- Table --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50/80 border-b border-gray-100">
                    <tr>
                        <th class="px-4 py-3 text-left text-[10px] font-bold uppercase tracking-wider text-gray-500">Perusahaan</th>
                        <th class="px-4 py-3 text-left text-[10px] font-bold uppercase tracking-wider text-gray-500">Jenis</th>
                        <th class="px-4 py-3 text-left text-[10px] font-bold uppercase tracking-wider text-gray-500">NPWP</th>
                        <th class="px-4 py-3 text-center text-[10px] font-bold uppercase tracking-wider text-gray-500">Status</th>
                        <th class="px-4 py-3 text-left text-[10px] font-bold uppercase tracking-wider text-gray-500">Tanggal</th>
                        <th class="px-4 py-3 text-center text-[10px] font-bold uppercase tracking-wider text-gray-500">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($mitraList as $m)
                        <tr class="hover:bg-gray-50/50 transition {{ $m->status === 'pending' ? 'bg-amber-50/30' : '' }}">
                            <td class="px-4 py-3">
                                <div class="font-semibold text-gray-800">{{ $m->nama_perusahaan }}</div>
                                <div class="text-[11px] text-gray-400">{{ $m->email }} · {{ $m->telepon }}</div>
                            </td>
                            <td class="px-4 py-3">
                                <span class="px-2 py-0.5 bg-gray-100 text-gray-600 rounded-md text-[10px] font-bold uppercase">{{ $m->jenis_mitra->label() }}</span>
                            </td>
                            <td class="px-4 py-3 font-mono text-xs text-gray-600">{{ $m->npwp }}</td>
                            <td class="px-4 py-3 text-center">
                                @php
                                    $sc = [
                                        'pending' => 'bg-amber-100 text-amber-700',
                                        'approved' => 'bg-green-100 text-green-700',
                                        'rejected' => 'bg-red-100 text-red-700',
                                    ];
                                @endphp
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-bold uppercase {{ $sc[$m->status] ?? '' }}">{{ $m->status }}</span>
                            </td>
                            <td class="px-4 py-3 text-xs text-gray-400">{{ $m->created_at->format('d/m/Y H:i') }}</td>
                            <td class="px-4 py-3 text-center">
                                <button wire:click="openDetail({{ $m->id }})" class="p-1.5 text-gray-400 hover:text-teal-600 hover:bg-teal-50 rounded-lg transition">
                                    <span class="material-symbols-outlined text-[18px]!">visibility</span>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="px-4 py-12 text-center text-gray-400">Belum ada pendaftaran mitra.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-4 py-3 border-t border-gray-100">{{ $mitraList->links() }}</div>
    </div>

    {{-- Detail / Approval Modal --}}
    @if($showDetail && $selected)
        <div class="fixed inset-0 bg-black/40 backdrop-blur-sm z-50 flex items-center justify-center p-4" wire:click.self="closeDetail">
            <div class="bg-white rounded-2xl shadow-2xl w-full max-w-xl max-h-[90vh] overflow-y-auto">
                <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
                    <h3 class="font-bold text-gray-800">Detail Pendaftaran Mitra</h3>
                    <button wire:click="closeDetail" class="p-1 hover:bg-gray-100 rounded-lg"><span class="material-symbols-outlined text-[20px]!">close</span></button>
                </div>
                <div class="px-6 py-5 space-y-5">
                    {{-- Status Badge --}}
                    <div class="flex items-center gap-3 p-3 rounded-xl {{ $selected->status === 'approved' ? 'bg-green-50' : ($selected->status === 'pending' ? 'bg-amber-50' : 'bg-red-50') }}">
                        <span class="material-symbols-outlined text-[24px]! {{ $selected->status === 'approved' ? 'text-green-600' : ($selected->status === 'pending' ? 'text-amber-600' : 'text-red-600') }}">
                            {{ $selected->status === 'approved' ? 'check_circle' : ($selected->status === 'pending' ? 'hourglass_top' : 'cancel') }}
                        </span>
                        <div>
                            <p class="font-bold text-sm uppercase">{{ $selected->status }}</p>
                            @if($selected->approved_at)<p class="text-[11px] text-gray-500">Disetujui: {{ $selected->approved_at->format('d M Y H:i') }}</p>@endif
                        </div>
                    </div>

                    {{-- Details Grid --}}
                    <div class="grid grid-cols-2 gap-4 text-sm">
                        <div><p class="text-[10px] uppercase font-bold text-gray-400 mb-0.5">Jenis Mitra</p><p class="text-gray-800 font-semibold">{{ $selected->jenis_mitra->label() }}</p></div>
                        <div><p class="text-[10px] uppercase font-bold text-gray-400 mb-0.5">Perusahaan</p><p class="text-gray-800 font-semibold">{{ $selected->nama_perusahaan }}</p></div>
                        <div><p class="text-[10px] uppercase font-bold text-gray-400 mb-0.5">Email</p><p class="text-gray-800">{{ $selected->email }}</p></div>
                        <div><p class="text-[10px] uppercase font-bold text-gray-400 mb-0.5">Telepon</p><p class="text-gray-800">{{ $selected->telepon }}</p></div>
                        <div class="col-span-2"><p class="text-[10px] uppercase font-bold text-gray-400 mb-0.5">NPWP</p><p class="text-gray-800 font-mono">{{ $selected->npwp }}</p></div>
                    </div>

                    {{-- Document Downloads --}}
                    <div class="grid grid-cols-2 gap-3">
                        <a href="{{ route('admin.mitra.dokumen', [$selected->id, 'npwp']) }}" target="_blank"
                           class="flex items-center gap-2 p-3 bg-gray-50 rounded-xl hover:bg-teal-50 transition text-sm font-semibold text-gray-700">
                            <span class="material-symbols-outlined text-[20px]! text-teal-600">description</span>
                            Dokumen NPWP
                            <span class="material-symbols-outlined text-[14px]! ml-auto text-gray-400">open_in_new</span>
                        </a>
                        <a href="{{ route('admin.mitra.dokumen', [$selected->id, 'legalitas']) }}" target="_blank"
                           class="flex items-center gap-2 p-3 bg-gray-50 rounded-xl hover:bg-teal-50 transition text-sm font-semibold text-gray-700">
                            <span class="material-symbols-outlined text-[20px]! text-teal-600">gavel</span>
                            Dok. Legalitas
                            <span class="material-symbols-outlined text-[14px]! ml-auto text-gray-400">open_in_new</span>
                        </a>
                    </div>

                    {{-- Admin Notes & Actions --}}
                    @if($selected->status === 'pending')
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1">Catatan Admin (opsional)</label>
                            <textarea wire:model="catatanAdmin" rows="2" placeholder="Tambahkan catatan untuk mitra..."
                                      class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-teal-500 resize-none"></textarea>
                        </div>

                        <div class="flex gap-3">
                            <button type="button"
                                    @click="Swal.fire({title:'Setujui Mitra?',text:'Akun login akan dibuat otomatis dan email konfirmasi akan dikirim.',icon:'question',showCancelButton:true,confirmButtonColor:'#059669',confirmButtonText:'Ya, Setujui',cancelButtonText:'Batal'}).then(r=>{if(r.isConfirmed)$wire.approve()})"
                                    class="flex-1 py-3 bg-gradient-to-r from-green-600 to-green-700 text-white font-bold rounded-xl hover:from-green-700 hover:to-green-800 shadow-lg transition-all flex items-center justify-center gap-2">
                                <span class="material-symbols-outlined text-[18px]!">check_circle</span>
                                Setujui
                            </button>
                            <button type="button"
                                    @click="Swal.fire({title:'Tolak Mitra?',text:'Email penolakan akan dikirim ke mitra.',icon:'warning',showCancelButton:true,confirmButtonColor:'#dc2626',confirmButtonText:'Ya, Tolak',cancelButtonText:'Batal'}).then(r=>{if(r.isConfirmed)$wire.reject()})"
                                    class="flex-1 py-3 bg-gradient-to-r from-red-600 to-red-700 text-white font-bold rounded-xl hover:from-red-700 hover:to-red-800 shadow-lg transition-all flex items-center justify-center gap-2">
                                <span class="material-symbols-outlined text-[18px]!">cancel</span>
                                Tolak
                            </button>
                        </div>
                    @else
                        @if($selected->catatan_admin)
                            <div class="p-3 bg-gray-50 rounded-xl">
                                <p class="text-[10px] uppercase font-bold text-gray-400 mb-1">Catatan Admin</p>
                                <p class="text-sm text-gray-700">{{ $selected->catatan_admin }}</p>
                            </div>
                        @endif

                        {{-- Status change for approved/rejected mitras --}}
                        <div class="border-t border-gray-100 pt-4">
                            <label class="block text-sm font-bold text-gray-700 mb-2">Ubah Status Mitra</label>
                            <div class="flex gap-3">
                                @if($selected->status === 'approved')
                                    <button type="button"
                                            @click="Swal.fire({title:'Nonaktifkan Mitra?',text:'Akun mitra akan dinonaktifkan dan tidak bisa login.',icon:'warning',showCancelButton:true,confirmButtonColor:'#dc2626',confirmButtonText:'Ya, Nonaktifkan',cancelButtonText:'Batal'}).then(r=>{if(r.isConfirmed)$wire.changeStatus('rejected')})"
                                            class="flex-1 py-2.5 bg-red-500 text-white font-bold rounded-xl hover:bg-red-600 text-sm flex items-center justify-center gap-2 transition">
                                        <span class="material-symbols-outlined text-[16px]!">block</span>
                                        Nonaktifkan Mitra
                                    </button>
                                @elseif($selected->status === 'rejected')
                                    <button type="button"
                                            @click="Swal.fire({title:'Aktifkan Kembali?',text:'Mitra akan diaktifkan kembali dan bisa login.',icon:'question',showCancelButton:true,confirmButtonColor:'#059669',confirmButtonText:'Ya, Aktifkan',cancelButtonText:'Batal'}).then(r=>{if(r.isConfirmed)$wire.changeStatus('approved')})"
                                            class="flex-1 py-2.5 bg-green-600 text-white font-bold rounded-xl hover:bg-green-700 text-sm flex items-center justify-center gap-2 transition">
                                        <span class="material-symbols-outlined text-[16px]!">check_circle</span>
                                        Aktifkan Kembali
                                    </button>
                                @endif
                            </div>
                        </div>
                    @endif

                    <p class="text-[11px] text-gray-400">Terdaftar: {{ $selected->created_at->format('d M Y H:i:s') }}</p>
                </div>
            </div>
        </div>
    @endif
</div>
