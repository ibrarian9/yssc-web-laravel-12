@props(['title', 'value', 'icon', 'color' => 'teal', 'trend' => null])

@php
    $colors = [
        'teal' => ['bg' => 'bg-teal-50', 'text' => 'text-teal-600', 'icon' => 'text-teal-500'],
        'orange' => ['bg' => 'bg-orange-50', 'text' => 'text-orange-600', 'icon' => 'text-orange-500'],
        'blue' => ['bg' => 'bg-blue-50', 'text' => 'text-blue-600', 'icon' => 'text-blue-500'],
        'purple' => ['bg' => 'bg-purple-50', 'text' => 'text-purple-600', 'icon' => 'text-purple-500'],
        'red' => ['bg' => 'bg-red-50', 'text' => 'text-red-600', 'icon' => 'text-red-500'],
    ];
    $c = $colors[$color] ?? $colors['teal'];
@endphp

<div class="bg-white rounded-xl p-5 shadow-sm border border-gray-100 hover:shadow-md transition">
    <div class="flex items-start justify-between">
        <div>
            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">{{ $title }}</p>
            <p class="text-2xl font-black text-gray-800">{{ $value }}</p>
            @if($trend)
                <p class="text-xs mt-1 {{ $trend > 0 ? 'text-green-500' : 'text-red-500' }}">
                    {{ $trend > 0 ? '↑' : '↓' }} {{ abs($trend) }}% dari bulan lalu
                </p>
            @endif
        </div>
        <div class="w-11 h-11 {{ $c['bg'] }} rounded-xl flex items-center justify-center">
            <span class="material-symbols-outlined text-[22px]! {{ $c['icon'] }}">{{ $icon }}</span>
        </div>
    </div>
</div>
