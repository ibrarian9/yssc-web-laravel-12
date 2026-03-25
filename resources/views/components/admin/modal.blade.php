@props([
    'title' => '',
    'maxWidth' => '2xl',
    'show' => false,
])

@php
    $maxWidthClass = [
        'sm' => 'sm:max-w-sm',
        'md' => 'sm:max-w-md',
        'lg' => 'sm:max-w-lg',
        'xl' => 'sm:max-w-xl',
        '2xl' => 'sm:max-w-2xl',
        '4xl' => 'sm:max-w-4xl',
    ][$maxWidth] ?? 'sm:max-w-2xl';
@endphp

<div x-data="{ show: @js($show) }"
     x-on:open-modal.window="if ($event.detail === '{{ $attributes->get('name', '') }}') show = true"
     x-on:close-modal.window="if ($event.detail === '{{ $attributes->get('name', '') }}') show = false"
     x-show="show"
     class="fixed inset-0 z-50"
     style="display: none;">

    {{-- Overlay --}}
    <div x-show="show" x-transition.opacity @click="show = false"
         class="fixed inset-0 bg-black/50 backdrop-blur-sm"></div>

    {{-- Modal Content --}}
    <div class="fixed inset-0 overflow-y-auto flex items-center justify-center p-4">
        <div x-show="show"
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-95"
             @click.away="show = false"
             class="bg-white rounded-2xl shadow-2xl w-full {{ $maxWidthClass }} max-h-[90vh] overflow-y-auto">

            {{-- Header --}}
            @if($title)
                <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
                    <h3 class="text-lg font-bold text-gray-800">{{ $title }}</h3>
                    <button @click="show = false" class="p-1 rounded-lg hover:bg-gray-100 transition">
                        <span class="material-symbols-outlined text-gray-400">close</span>
                    </button>
                </div>
            @endif

            {{-- Body --}}
            <div class="p-6">
                {{ $slot }}
            </div>

            {{-- Footer --}}
            @if(isset($footer))
                <div class="px-6 py-4 border-t border-gray-100 flex justify-end gap-3">
                    {{ $footer }}
                </div>
            @endif
        </div>
    </div>
</div>
