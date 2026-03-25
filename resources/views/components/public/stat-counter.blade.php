@props(['value', 'label', 'icon', 'prefix' => '', 'suffix' => ''])

<div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 text-center group hover:shadow-lg transition-all duration-300">
    <div class="w-14 h-14 mx-auto mb-3 bg-teal-50 rounded-xl flex items-center justify-center group-hover:bg-teal-100 transition">
        <span class="material-symbols-outlined text-[28px]! text-teal-600">{{ $icon }}</span>
    </div>
    <h3 class="text-3xl md:text-4xl font-black text-gray-800 mb-1"
        x-data="{ current: 0, target: {{ $value }} }"
        x-init="
            let step = Math.ceil(target / 60);
            let interval = setInterval(() => {
                current += step;
                if (current >= target) { current = target; clearInterval(interval); }
            }, 16);
        "
        x-text="'{{ $prefix }}' + current.toLocaleString('id-ID') + '{{ $suffix }}'">
        {{ $prefix }}{{ number_format($value, 0, ',', '.') }}{{ $suffix }}
    </h3>
    <p class="text-sm text-gray-400 font-medium">{{ $label }}</p>
</div>
