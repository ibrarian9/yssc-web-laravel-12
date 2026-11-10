@props([
    'page',
    'badge' => null,
    'defaultTitle' => '',
    'defaultSubtitle' => '',
])

@php
    $hero = \App\Models\HeroSection::getHero($page);
    $isActive = $hero ? (bool) $hero->is_active : true;
    $title = ($hero && !empty($hero->judul)) ? $hero->judul : $defaultTitle;
    $subtitle = ($hero && !empty($hero->subjudul)) ? $hero->subjudul : $defaultSubtitle;
    $hasImage = $isActive && $hero && !empty($hero->gambar);
    $opacity = $hero->overlay_opacity ?? 60;
@endphp

<section class="relative py-12 sm:py-16 md:py-24 overflow-hidden text-center transition-all duration-300 {{ $hasImage ? 'bg-gray-900' : 'bg-gradient-to-br from-gray-900 via-gray-800 to-teal-900' }}"
    @if($hasImage)
        style="background-image: url('{{ asset('storage/' . $hero->gambar) }}'); background-size: cover; background-position: center;"
    @endif
>
    @if($hasImage)
        <div class="absolute inset-0 bg-black" style="opacity: {{ $opacity / 100 }};"></div>
    @else
        <div class="absolute inset-0 opacity-10">
            <div class="absolute top-10 left-10 w-72 h-72 rounded-full bg-teal-400 blur-[100px]"></div>
            <div class="absolute bottom-10 right-10 w-96 h-96 rounded-full bg-amber-400 blur-[120px]"></div>
        </div>
    @endif

    <div class="container mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        @if($badge)
            <span class="inline-block px-4 py-1.5 bg-teal-500/20 text-teal-300 text-xs font-bold uppercase tracking-widest rounded-full mb-4 border border-teal-500/30">
                {{ $badge }}
            </span>
        @endif

        <h1 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-extrabold text-white mb-4 leading-tight drop-shadow-sm">
            {{ $title }}
        </h1>

        @if($subtitle)
            <p class="text-gray-200 text-base sm:text-lg md:text-xl max-w-2xl mx-auto leading-relaxed drop-shadow-sm">
                {{ $subtitle }}
            </p>
        @endif

        {{ $slot }}
    </div>
</section>

