<x-layouts.public>
    <x-slot:title>Kegiatan — Yayasan Seribu Satu Cita</x-slot:title>

    <section class="bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900 py-16 md:py-20">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-3xl md:text-5xl font-extrabold text-white mb-4">Kegiatan</h1>
            <p class="text-gray-400 text-lg max-w-xl mx-auto">Dokumentasi kegiatan dan program yayasan kami</p>
        </div>
    </section>

    <section class="py-12 lg:py-16">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-7xl">
            <livewire:public-pages.berita-list :tipe="'kegiatan'" />
        </div>
    </section>
</x-layouts.public>
