<div>
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
        <div><h2 class="text-2xl font-extrabold text-gray-800">Audit Log</h2><p class="text-sm text-gray-500">Riwayat aktivitas perubahan data di sistem</p></div>
    </div>

    {{-- Filters --}}
    <div class="bg-white rounded-2xl p-5 shadow-md border border-gray-100 mb-8 flex flex-col lg:flex-row gap-4 items-stretch">
        <div class="flex-1 relative">
            <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-[20px]!">search</span>
            <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari aktivitas..."
                   class="w-full pl-12 pr-4 py-3 border border-gray-200 rounded-xl text-base focus:ring-2 focus:ring-teal-500 focus:border-teal-500 bg-gray-50/30 focus:bg-white">
        </div>
        <div class="flex gap-3">
            <select wire:model.live="filterEvent" class="min-w-[130px] px-4 py-3 border border-gray-200 rounded-xl text-sm font-medium focus:ring-2 focus:ring-teal-500 bg-white">
                <option value="">Semua Event</option>
                <option value="created">Created</option>
                <option value="updated">Updated</option>
                <option value="deleted">Deleted</option>
            </select>
            <select wire:model.live="filterSubject" class="min-w-[130px] px-4 py-3 border border-gray-200 rounded-xl text-sm font-medium focus:ring-2 focus:ring-teal-500 bg-white">
                <option value="">Semua Model</option>
                @foreach($subjectTypes as $st)
                    <option value="{{ $st['full'] }}">{{ $st['short'] }}</option>
                @endforeach
            </select>
        </div>
    </div>

    {{-- Table --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 border-b border-gray-100"><tr class="text-left text-xs text-gray-500 uppercase tracking-wider">
                    <th class="px-4 py-3">Waktu</th>
                    <th class="px-4 py-3">User</th>
                    <th class="px-4 py-3">Event</th>
                    <th class="px-4 py-3">Model</th>
                    <th class="px-4 py-3">Deskripsi</th>
                    <th class="px-4 py-3 text-right">Aksi</th>
                </tr></thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($logs as $log)
                        @php
                            $eventColors = [
                                'created' => 'bg-green-100 text-green-700',
                                'updated' => 'bg-blue-100 text-blue-700',
                                'deleted' => 'bg-red-100 text-red-700',
                            ];
                            $eventColor = $eventColors[$log->event] ?? 'bg-gray-100 text-gray-600';
                        @endphp
                        <tr class="hover:bg-gray-50/50">
                            <td class="px-4 py-3 whitespace-nowrap">
                                <p class="text-gray-800 font-medium text-xs">{{ $log->created_at->format('d/m/Y') }}</p>
                                <p class="text-gray-400 text-[10px]">{{ $log->created_at->format('H:i:s') }}</p>
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex items-center gap-2">
                                    <div class="w-7 h-7 rounded-full bg-teal-100 flex items-center justify-center shrink-0">
                                        <span class="material-symbols-outlined text-teal-600 text-[14px]!">person</span>
                                    </div>
                                    <span class="text-gray-700 font-medium text-xs">{{ $log->causer?->name ?? 'System' }}</span>
                                </div>
                            </td>
                            <td class="px-4 py-3">
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold uppercase {{ $eventColor }}">{{ $log->event ?? '-' }}</span>
                            </td>
                            <td class="px-4 py-3">
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-purple-50 text-purple-700">{{ class_basename($log->subject_type ?? '-') }}</span>
                                @if($log->subject_id) <span class="text-[10px] text-gray-400 ml-1">#{{ $log->subject_id }}</span> @endif
                            </td>
                            <td class="px-4 py-3 text-gray-600 text-xs max-w-[200px] truncate">{{ $log->description }}</td>
                            <td class="px-4 py-3 text-right">
                                <button wire:click="openDetail({{ $log->id }})" class="p-1.5 rounded-lg hover:bg-teal-50 text-teal-600" title="Detail">
                                    <span class="material-symbols-outlined text-[18px]!">visibility</span>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="px-4 py-10 text-center text-gray-400">
                            <span class="material-symbols-outlined text-[48px]! text-gray-300 mb-2">history</span>
                            <p>Belum ada log aktivitas.</p>
                        </td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($logs->hasPages()) <div class="p-4 border-t border-gray-100">{{ $logs->links() }}</div> @endif
    </div>

    {{-- Detail Modal --}}
    @if($showDetail && $detail)
    <div class="fixed inset-0 z-50 flex items-center justify-center p-4">
        <div class="fixed inset-0 bg-black/50 backdrop-blur-sm" wire:click="closeDetail"></div>
        <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-lg max-h-[90vh] overflow-y-auto">
            <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
                <h3 class="text-lg font-bold text-gray-800">Detail Log #{{ $detail->id }}</h3>
                <button wire:click="closeDetail" class="p-1 rounded-lg hover:bg-gray-100"><span class="material-symbols-outlined text-gray-400">close</span></button>
            </div>
            <div class="p-6 space-y-4">
                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div>
                        <p class="text-[10px] uppercase font-bold text-gray-400 mb-0.5">Waktu</p>
                        <p class="text-gray-800 font-semibold">{{ $detail->created_at->format('d/m/Y H:i:s') }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] uppercase font-bold text-gray-400 mb-0.5">User</p>
                        <p class="text-gray-800 font-semibold">{{ $detail->causer?->name ?? 'System' }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] uppercase font-bold text-gray-400 mb-0.5">Event</p>
                        @php $ec = $eventColors[$detail->event] ?? 'bg-gray-100 text-gray-600'; @endphp
                        <span class="px-2 py-0.5 rounded-full text-xs font-bold uppercase {{ $ec }}">{{ $detail->event }}</span>
                    </div>
                    <div>
                        <p class="text-[10px] uppercase font-bold text-gray-400 mb-0.5">Model</p>
                        <p class="text-gray-800 font-semibold">{{ class_basename($detail->subject_type ?? '-') }} #{{ $detail->subject_id }}</p>
                    </div>
                </div>

                <div>
                    <p class="text-[10px] uppercase font-bold text-gray-400 mb-1">Deskripsi</p>
                    <p class="text-sm text-gray-700">{{ $detail->description }}</p>
                </div>

                @if($detail->properties && $detail->properties->count() > 0)
                    {{-- Changes --}}
                    @if($detail->properties->has('old') && $detail->properties->has('attributes'))
                        <div>
                            <p class="text-[10px] uppercase font-bold text-gray-400 mb-2">Perubahan</p>
                            <div class="rounded-xl border border-gray-100 overflow-hidden text-xs">
                                <table class="w-full">
                                    <thead class="bg-gray-50"><tr>
                                        <th class="px-3 py-2 text-left text-gray-500 font-semibold">Field</th>
                                        <th class="px-3 py-2 text-left text-red-500 font-semibold">Sebelum</th>
                                        <th class="px-3 py-2 text-left text-green-600 font-semibold">Sesudah</th>
                                    </tr></thead>
                                    <tbody class="divide-y divide-gray-50">
                                        @foreach($detail->properties['attributes'] as $key => $newVal)
                                            <tr>
                                                <td class="px-3 py-1.5 font-medium text-gray-700">{{ $key }}</td>
                                                <td class="px-3 py-1.5 text-red-600 bg-red-50/50">{{ $detail->properties['old'][$key] ?? '—' }}</td>
                                                <td class="px-3 py-1.5 text-green-700 bg-green-50/50">{{ is_array($newVal) ? json_encode($newVal) : $newVal }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @elseif($detail->properties->has('attributes'))
                        <div>
                            <p class="text-[10px] uppercase font-bold text-gray-400 mb-2">Data</p>
                            <div class="rounded-xl border border-gray-100 overflow-hidden text-xs">
                                <table class="w-full">
                                    <thead class="bg-gray-50"><tr>
                                        <th class="px-3 py-2 text-left text-gray-500 font-semibold">Field</th>
                                        <th class="px-3 py-2 text-left text-gray-500 font-semibold">Nilai</th>
                                    </tr></thead>
                                    <tbody class="divide-y divide-gray-50">
                                        @foreach($detail->properties['attributes'] as $key => $val)
                                            <tr>
                                                <td class="px-3 py-1.5 font-medium text-gray-700">{{ $key }}</td>
                                                <td class="px-3 py-1.5 text-gray-600">{{ is_array($val) ? json_encode($val) : $val }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @else
                        <div>
                            <p class="text-[10px] uppercase font-bold text-gray-400 mb-2">Properties</p>
                            <pre class="text-xs bg-gray-50 rounded-xl p-3 overflow-x-auto text-gray-600">{{ json_encode($detail->properties, JSON_PRETTY_PRINT) }}</pre>
                        </div>
                    @endif
                @endif
            </div>
        </div>
    </div>
    @endif
</div>
