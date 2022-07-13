@if($description !== "")
    <span class="text-2xl md:text-3xl xl:text-4xl font-bold">{{ $title }}
        @include('partials.showDescription')
    </span>

    <div class="hidden" id="description-area">
        @isset($featured)
            @if ($featured !== '')
                <img src="{{ asset($featured) }}" alt="{{ $title }}" class="transform scale-50">
            @endif
        @endisset
        {{ $slot }}
    </div>
@else
    <p class="text-2xl md:text-3xl xl:text-4xl font-bold">{{ $title }}</p>
    @isset($featured)
        @if ($featured !== '')
            <img src="{{ asset($featured) }}" alt="{{ $title }}" class="transform scale-50">
        @endif
    @endisset
@endif