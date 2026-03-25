<div>
    @if($submitted)
        <div class="text-center py-12">
            <div class="w-20 h-20 mx-auto mb-4 bg-green-100 rounded-full flex items-center justify-center">
                <span class="material-symbols-outlined text-[40px]! text-green-600">check_circle</span>
            </div>
            <h3 class="text-2xl font-extrabold text-gray-800 mb-2">Pendaftaran Berhasil!</h3>
            <p class="text-gray-500 max-w-md mx-auto mb-6">Terima kasih telah mendaftar sebagai mitra YSSC. Kami akan meninjau dokumen Anda dan mengirimkan email konfirmasi setelah disetujui.</p>
            <a href="{{ route('home') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-teal-600 to-teal-700 text-white font-bold rounded-xl hover:from-teal-700 hover:to-teal-800 shadow-lg transition">
                <span class="material-symbols-outlined text-[18px]!">home</span>Ke Beranda
            </a>
        </div>
    @else
        <form wire:submit="submit" class="space-y-6">
            {{-- Jenis Mitra --}}
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Jenis Mitra <span class="text-red-500">*</span></label>
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                    @foreach($jenisOptions as $jenis)
                        <label class="relative cursor-pointer">
                            <input type="radio" wire:model.live="jenisMitra" value="{{ $jenis->value }}" class="peer sr-only">
                            <div class="px-4 py-3 border-2 rounded-xl text-center text-sm font-semibold transition-all
                                        peer-checked:border-teal-600 peer-checked:bg-teal-50 peer-checked:text-teal-700
                                        border-gray-200 text-gray-600 hover:border-teal-300">
                                {{ $jenis->label() }}
                            </div>
                        </label>
                    @endforeach
                </div>
                @error('jenisMitra') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Nama Perusahaan --}}
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-1">Nama Perusahaan / Organisasi <span class="text-red-500">*</span></label>
                <input type="text" wire:model="namaPerusahaan" placeholder="PT. Nama Perusahaan"
                       class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
                @error('namaPerusahaan') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Email & Telepon --}}
            <div class="grid sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Alamat Email <span class="text-red-500">*</span></label>
                    <input type="email" wire:model="email" placeholder="email@perusahaan.com"
                           class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
                    @error('email') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Nomor Telepon <span class="text-red-500">*</span></label>
                    <input type="text" wire:model="telepon" placeholder="08xxxxxxxxxx"
                           class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
                    @error('telepon') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            {{-- NPWP --}}
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-1">Nomor NPWP <span class="text-red-500">*</span></label>
                <input type="text" wire:model="npwp" placeholder="00.000.000.0-000.000"
                       class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-teal-500 focus:border-teal-500 font-mono">
                @error('npwp') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Upload Dokumen --}}
            <div class="grid sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Verifikasi NPWP <span class="text-red-500">*</span></label>
                    <p class="text-[11px] text-gray-400 mb-2">Upload foto/scan NPWP (PDF, JPG, PNG, maks 5MB)</p>
                    <input type="file" wire:model="dokumenNpwp" accept=".pdf,.jpg,.jpeg,.png"
                           class="w-full text-sm file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-teal-50 file:text-teal-700 file:font-semibold file:cursor-pointer">
                    <div wire:loading wire:target="dokumenNpwp" class="text-xs text-teal-600 mt-1">Mengupload...</div>
                    @error('dokumenNpwp') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Dokumen Legalitas <span class="text-red-500">*</span></label>
                    <p class="text-[11px] text-gray-400 mb-2">SIUP, Akta, atau surat legalitas (PDF, JPG, PNG, maks 5MB)</p>
                    <input type="file" wire:model="dokumenLegalitas" accept=".pdf,.jpg,.jpeg,.png"
                           class="w-full text-sm file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-teal-50 file:text-teal-700 file:font-semibold file:cursor-pointer">
                    <div wire:loading wire:target="dokumenLegalitas" class="text-xs text-teal-600 mt-1">Mengupload...</div>
                    @error('dokumenLegalitas') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            {{-- Terms --}}
            <div class="bg-gray-50 rounded-xl p-4 border border-gray-100">
                <label class="flex items-start gap-3 cursor-pointer">
                    <input type="checkbox" wire:model="agreeTerms" class="rounded border-gray-300 text-teal-600 focus:ring-teal-500 mt-0.5">
                    <span class="text-sm text-gray-600">
                        Saya menyetujui <a href="#" class="text-teal-600 font-semibold hover:underline">Syarat dan Ketentuan</a>
                        serta <a href="#" class="text-teal-600 font-semibold hover:underline">Kebijakan Privasi</a> Yayasan Seribu Satu Cita.
                    </span>
                </label>
                @error('agreeTerms') <p class="text-xs text-red-500 mt-2">{{ $message }}</p> @enderror
            </div>

            {{-- Submit --}}
            <button type="submit"
                    class="w-full py-3.5 bg-gradient-to-r from-teal-600 to-teal-700 text-white font-bold rounded-xl hover:from-teal-700 hover:to-teal-800 shadow-lg shadow-teal-500/20 transition-all hover:shadow-xl disabled:opacity-50"
                    wire:loading.attr="disabled">
                <span wire:loading.remove class="inline-flex items-center gap-2">
                    <span class="material-symbols-outlined text-[18px]!">handshake</span>
                    Daftar Sebagai Mitra
                </span>
                <span wire:loading class="inline-flex items-center gap-2">
                    <svg class="animate-spin h-4 w-4" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" fill="none"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/></svg>
                    Memproses Pendaftaran...
                </span>
            </button>
        </form>
    @endif
</div>
