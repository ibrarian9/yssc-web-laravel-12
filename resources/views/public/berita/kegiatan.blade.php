<x-layouts.public>
    <x-slot:title>Kegiatan — Yayasan Seribu Satu Cita</x-slot:title>

    {{-- Hero --}}
    <x-public.page-hero page="kegiatan" default-title="Kegiatan Yayasan" default-subtitle="Dokumentasi kegiatan dan program yayasan kami" />

    <section class="py-12 lg:py-16">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-7xl">
            <livewire:public-pages.berita-list :tipe="'kegiatan'" />
        </div>
    </section>
</x-layouts.public>
