@props(['value', 'label', 'icon', 'prefix' => '', 'suffix' => ''])

@php
    $numericValue = (int) $value;
    $formatted = $prefix . number_format($numericValue, 0, ',', '.') . $suffix;
    $len = strlen($formatted);
    $sizeClass = match (true) {
        $len >= 13 => 'text-lg sm:text-xl md:text-2xl',
        $len >= 9 => 'text-2xl md:text-3xl',
        default => 'text-3xl md:text-4xl',
    };
@endphp

<div class="bg-white rounded-2xl p-4 sm:p-6 shadow-sm border border-gray-100 text-center group hover:shadow-lg transition-all duration-300 h-full flex flex-col items-center justify-center">
    <div class="w-14 h-14 mx-auto mb-3 bg-teal-50 rounded-xl flex items-center justify-center group-hover:bg-teal-100 transition shrink-0">
        <span class="material-symbols-outlined text-[28px]! text-teal-600">{{ $icon }}</span>
    </div>
    <div class="min-h-[40px] flex items-center justify-center mb-1">
        <h3 class="{{ $sizeClass }} font-black text-gray-800 whitespace-nowrap"
            x-data="{ current: 0, target: {{ $numericValue }} }"
            x-init="
                if (target > 0) {
                    let step = Math.ceil(target / 60);
                    let interval = setInterval(() => {
                        current += step;
                        if (current >= target) { current = target; clearInterval(interval); }
                    }, 16);
                }
            "
            x-text="'{{ $prefix }}' + current.toLocaleString('id-ID') + '{{ $suffix }}'">
            {{ $formatted }}
        </h3>
    </div>
    <p class="text-sm text-gray-400 font-medium">{{ $label }}</p>
</div>
