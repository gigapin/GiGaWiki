<div class="flex justify-between border-b border-gray-200 mx-2">
    <div class="w-1/2 pr-4">
        <h4>{{ $title }}</h4>
        <p class="text-xs">
            {{ $slot }}
        </p>
    </div>
    <div class="w-1/2">
        <div class="mt-8">
            @if($type === 'checkbox')
                @if($value === 'true')
                    <input type="{{ $type }}" name="{{ $name }}" checked> {{ $title }}
                @else
                    <input type="{{ $type }}" name="{{ $name }}" > {{ $title }}
                @endif
            @elseif ($type !== '')
                <input type="{{ $type }}" name="{{ $name }}" value="{{ $value }}" />
            @endif
            @if ($link !== null)
                <a href="{{ $link }}" class="inline-flex items-center px-4 py-2 bg-green-500 border border-transparent rounded-md font-semibold text-xs text-white hover:text-white hover:no-underline uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                    {{ $value }}
                </a>
            @endif
        </div>
    </div>
</div>