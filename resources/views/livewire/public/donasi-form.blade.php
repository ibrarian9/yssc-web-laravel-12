<div x-data="{
    snapReady: false,
    paymentPending: false,
    init() {
        // Listen for Livewire event to open Snap
        Livewire.on('open-snap', (data) => {
            if (window.snap && data.token) {
                window.snap.pay(data.token, {
                    onSuccess: (result) => {
                        $wire.paymentSuccess();
                    },
                    onPending: (result) => {
                        this.paymentPending = true;
                        $wire.paymentPending();
                    },
                    onError: (result) => {
                        $wire.paymentError();
                    },
                    onClose: () => {
                        // User closed the popup without completing
                    }
                });
            }
        });
    }
}">
    @if($submitted)
        <div class="text-center py-6">
            @if($snapToken && !$errorMsg)
                <div class="w-16 h-16 mx-auto mb-3 bg-green-100 rounded-full flex items-center justify-center">
                    <span class="material-symbols-outlined text-[32px]! text-green-600">check_circle</span>
                </div>
                <h4 class="font-bold text-gray-800 text-lg mb-1">Terima Kasih!</h4>
                <p class="text-sm text-gray-500 mb-4">Donasi Anda sedang diproses oleh Midtrans.</p>
                <p class="text-xs text-gray-400">Status pembayaran akan diperbarui secara otomatis.</p>
            @else
                <div class="w-16 h-16 mx-auto mb-3 bg-amber-100 rounded-full flex items-center justify-center">
                    <span class="material-symbols-outlined text-[32px]! text-amber-600">schedule</span>
                </div>
                <h4 class="font-bold text-gray-800 text-lg mb-1">Menunggu Pembayaran</h4>
                <p class="text-sm text-gray-500">Selesaikan pembayaran Anda untuk menyelesaikan donasi.</p>
            @endif
        </div>
    @else
        <form wire:submit="submit" class="space-y-4">
            {{-- Error message --}}
            @if($errorMsg)
                <div class="flex items-center gap-2 p-3 bg-red-50 border border-red-200 rounded-xl">
                    <span class="material-symbols-outlined text-red-500 text-[18px]!">error</span>
                    <p class="text-sm text-red-600">{{ $errorMsg }}</p>
                </div>
            @endif

            {{-- Preset amounts --}}
            <div>
                <label class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Pilih Nominal</label>
                <div class="grid grid-cols-3 gap-2 mt-2">
                    @foreach([50000, 100000, 200000, 500000, 1000000, 2000000] as $amount)
                        <button type="button" wire:click="setNominal({{ $amount }})"
                                class="py-2 rounded-lg text-xs font-bold transition-all border
                                       {{ $nominal === $amount ? 'bg-teal-600 text-white border-teal-600' : 'bg-white text-gray-600 border-gray-200 hover:border-teal-400' }}">
                            {{ $amount >= 1000000 ? ($amount / 1000000) . ' Jt' : ($amount / 1000) . ' Rb' }}
                        </button>
                    @endforeach
                </div>
            </div>

            {{-- Custom amount --}}
            <div>
                <label class="text-xs font-semibold text-gray-500">Atau masukkan nominal lain</label>
                <input type="number" wire:model.live="nominal" min="10000"
                       class="w-full mt-1 px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-teal-500 focus:border-teal-500"
                       placeholder="Rp 0">
                @error('nominal') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Name --}}
            <div>
                <input type="text" wire:model="namaCustom" placeholder="Nama Anda *"
                       class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
                @error('namaCustom') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Email --}}
            <div>
                <input type="email" wire:model="emailCustom" placeholder="Email Anda *"
                       class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
                @error('emailCustom') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Phone --}}
            <div>
                <input type="text" wire:model="phone" placeholder="No. HP (opsional)"
                       class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
            </div>

            {{-- Message --}}
            <div>
                <textarea wire:model="pesan" rows="2" placeholder="Pesan / doa (opsional)"
                          class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-teal-500 focus:border-teal-500 resize-none"></textarea>
            </div>

            {{-- Anonymous toggle --}}
            <label class="flex items-center gap-2 cursor-pointer">
                <input type="checkbox" wire:model="isAnonim" class="rounded border-gray-300 text-teal-600 focus:ring-teal-500">
                <span class="text-sm text-gray-600">Sembunyikan nama saya (donasi anonim)</span>
            </label>

            {{-- Midtrans badge --}}
            <div class="flex items-center gap-2 px-3 py-2 bg-gray-50 rounded-lg border border-gray-100">
                <span class="material-symbols-outlined text-[16px]! text-gray-400">lock</span>
                <span class="text-[11px] text-gray-400">Pembayaran aman diproses oleh <strong class="text-gray-600">Midtrans</strong></span>
            </div>

            {{-- Submit --}}
            <button type="submit"
                    class="w-full py-3 bg-gradient-to-r from-teal-600 to-teal-700 text-white font-bold rounded-xl hover:from-teal-700 hover:to-teal-800 shadow-lg shadow-teal-500/20 transition-all hover:shadow-xl disabled:opacity-50"
                    wire:loading.attr="disabled">
                <span wire:loading.remove>
                    Donasi Rp {{ number_format($nominal, 0, ',', '.') }}
                </span>
                <span wire:loading class="inline-flex items-center gap-2">
                    <svg class="animate-spin h-4 w-4" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" fill="none"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/></svg>
                    Menghubungkan ke Midtrans...
                </span>
            </button>
        </form>
    @endif
</div>
