<x-layouts.public>
    <x-slot:title>Berita — Yayasan Seribu Satu Cita</x-slot:title>
    <x-slot:metaDescription>Berita dan kegiatan terbaru dari Yayasan Seribu Satu Cita</x-slot:metaDescription>

    {{-- Hero --}}
    <x-public.page-hero page="berita" default-title="Berita & Kegiatan" default-subtitle="Ikuti perkembangan terbaru dari program dan kegiatan yayasan kami" />

    {{-- Content --}}
    <section class="py-12 lg:py-16">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-7xl">
            <livewire:public-pages.berita-list />
        </div>
    </section>
</x-layouts.public>
