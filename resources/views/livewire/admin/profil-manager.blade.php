<div>
    <div class="mb-6"><h2 class="text-2xl font-extrabold text-gray-800">Profil Organisasi</h2><p class="text-sm text-gray-500">Edit informasi publik yayasan</p></div>

    <form wire:submit="save" class="space-y-6">
        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 space-y-4">
            <h3 class="font-bold text-gray-700">Informasi Utama</h3>
            <div class="grid sm:grid-cols-2 gap-4">
                <div><label class="block text-sm font-semibold text-gray-700 mb-1">Nama Organisasi *</label><input type="text" wire:model="nama_organisasi" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-teal-500">@error('nama_organisasi')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror</div>
                <div><label class="block text-sm font-semibold text-gray-700 mb-1">Tagline</label><input type="text" wire:model="tagline" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-teal-500"></div>
            </div>
            <div><label class="block text-sm font-semibold text-gray-700 mb-1">Deskripsi Singkat</label><textarea wire:model="deskripsi" rows="3" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-teal-500 resize-none"></textarea></div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Logo <span class="text-xs text-gray-400 font-normal">(maks. 1MB)</span></label>
                <div class="flex items-center gap-4">
                    @php $currentLogo = \App\Models\Profile::first()?->logo; @endphp
                    @if($currentLogo && !$newLogo)
                        <img src="{{ asset('storage/' . $currentLogo) }}" alt="Logo saat ini" class="w-16 h-16 rounded-xl object-contain border border-gray-200 bg-gray-50 p-1">
                    @endif
                    @if($newLogo)
                        <img src="{{ $newLogo->temporaryUrl() }}" alt="Preview logo baru" class="w-16 h-16 rounded-xl object-contain border-2 border-teal-400 bg-teal-50 p-1">
                    @endif
                    <input type="file" wire:model="newLogo" accept="image/*" class="flex-1 text-sm file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-teal-50 file:text-teal-700 file:font-semibold hover:file:bg-teal-100">
                </div>
                @error('newLogo') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 space-y-4">
            <h3 class="font-bold text-gray-700">Visi & Misi</h3>
            <div><label class="block text-sm font-semibold text-gray-700 mb-1">Visi</label><textarea wire:model="visi" rows="2" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-teal-500 resize-none"></textarea></div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Misi</label>
                @foreach($misi as $idx => $m)
                    <div class="flex gap-2 mb-2">
                        <span class="mt-2.5 text-xs text-gray-400 font-bold w-6 shrink-0">{{ $idx + 1 }}.</span>
                        <input type="text" wire:model="misi.{{ $idx }}" class="flex-1 px-4 py-2 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-teal-500">
                        @if(count($misi) > 1)<button type="button" wire:click="removeMisi({{ $idx }})" class="p-1 text-red-400 hover:text-red-600"><span class="material-symbols-outlined text-[18px]!">close</span></button>@endif
                    </div>
                @endforeach
                <button type="button" wire:click="addMisi" class="text-sm text-teal-600 font-semibold hover:underline">+ Tambah misi</button>
            </div>
        </div>

        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 space-y-4">
            <h3 class="font-bold text-gray-700">Sejarah</h3>
            <textarea wire:model="sejarah" rows="6" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-teal-500 resize-y" placeholder="HTML diperbolehkan..."></textarea>
        </div>

        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 space-y-4">
            <h3 class="font-bold text-gray-700">Kontak & Sosial Media</h3>
            <div class="grid sm:grid-cols-2 gap-4">
                <div><label class="block text-sm font-semibold text-gray-700 mb-1">Alamat</label><input type="text" wire:model="alamat" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-teal-500"></div>
                <div><label class="block text-sm font-semibold text-gray-700 mb-1">Email</label><input type="email" wire:model="email" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-teal-500"></div>
                <div><label class="block text-sm font-semibold text-gray-700 mb-1">Telepon</label><input type="text" wire:model="telepon" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-teal-500"></div>
                <div><label class="block text-sm font-semibold text-gray-700 mb-1">WhatsApp</label><input type="text" wire:model="whatsapp" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-teal-500"></div>
                <div><label class="block text-sm font-semibold text-gray-700 mb-1">Instagram</label><input type="text" wire:model="instagram" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-teal-500" placeholder="URL"></div>
                <div><label class="block text-sm font-semibold text-gray-700 mb-1">Facebook</label><input type="text" wire:model="facebook" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-teal-500" placeholder="URL"></div>
            </div>
        </div>

        <div class="flex justify-end">
            <button type="submit" class="px-8 py-3 bg-gradient-to-r from-teal-600 to-teal-700 text-white font-bold rounded-xl hover:from-teal-700 hover:to-teal-800 shadow-lg shadow-teal-500/20 transition" wire:loading.attr="disabled">
                <span wire:loading.remove>Simpan Profil</span><span wire:loading>Menyimpan...</span>
            </button>
        </div>
    </form>
</div>
