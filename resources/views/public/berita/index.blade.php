<x-layouts.public>
    <x-slot:title>Berita — Yayasan Seribu Satu Cita</x-slot:title>
    <x-slot:metaDescription>Berita dan kegiatan terbaru dari Yayasan Seribu Satu Cita</x-slot:metaDescription>

    {{-- Hero --}}
    <section class="bg-linear-to-br from-gray-900 via-gray-800 to-gray-900 py-16 md:py-20">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-3xl md:text-5xl font-extrabold text-white mb-4">Berita & Kegiatan</h1>
            <p class="text-gray-400 text-lg max-w-xl mx-auto">Ikuti perkembangan terbaru dari program dan kegiatan yayasan kami</p>
        </div>
    </section>

    {{-- Content --}}
    <section class="py-12 lg:py-16">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-7xl">
            <livewire:public-pages.berita-list />
        </div>
    </section>
</x-layouts.public>
