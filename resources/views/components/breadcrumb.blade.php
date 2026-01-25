@props(['items' => []])

@if(count($items) > 0)
<nav class="flex items-center space-x-2 text-sm mb-6 overflow-x-auto pb-2">
    @foreach($items as $index => $item)
        @if($index > 0)
            <!-- Chevron Separator -->
            <svg class="w-4 h-4 text-gray-400 dark:text-gray-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
        @endif

        <div class="flex items-center gap-2 px-3 py-2 rounded-lg {{ $item['url'] ?? false ? 'hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors' : '' }}" 
             @if(($item['color'] ?? false)) style="border-left: 3px solid {{ $item['color'] }};" @endif>
            
            @if($item['icon'] ?? false)
                <div class="flex-shrink-0">
                    @if(Str::endsWith($item['icon'], '.png'))
                        <img src="{{ asset('size-512/images/' . $item['icon']) }}" alt="" class="w-5 h-5 object-contain">
                    @else
                        <span class="text-lg">{{ $item['icon'] }}</span>
                    @endif
                </div>
            @endif

            @if($item['url'] ?? false)
                <a href="{{ $item['url'] }}" class="text-gray-600 dark:text-gray-400 hover:text-indigo-600 dark:hover:text-indigo-400 font-medium whitespace-nowrap">
                    {{ $item['label'] }}
                </a>
            @else
                <span class="text-gray-900 dark:text-white font-semibold whitespace-nowrap">
                    {{ $item['label'] }}
                </span>
            @endif
        </div>
    @endforeach
</nav>
@endif
