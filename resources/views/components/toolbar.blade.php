<div class="absolute top-36 mt-1 ml-2 w-full z-0 md:w-8/12 lg:mt-0 lg:static lg:block lg:row-start-1 lg:row-end-1 lg:ml-4 2xl:ml-0 lg:mb-4 2xl:w-80" id="last-box">
    @if ($link !== null && $page !== null)
        <div class="p-2 w-6/12 lg:w-full lg:mx-auto lg:p-2 lg:ml-0 2xl:w-8/12 2xl:mx-auto text-base lg:text-lg">
            @if ($id !== null)
                <a href="{{ route($link, $id) }}">
                    <i class="bi bi-plus-square icons"></i>
                    {{ $page }}
                </a>
            @elseif($icon !== true)
                <a href="{{ route($link, $id) }}">
                    <i class="bi bi-list-check icons"></i>
                    {{ $page }}
                </a>
            @else
                <a href="{{ route($link) }}">
                    <i class="bi bi-plus-square icons"></i>
                    {{ $page }}
                </a>
            @endif
        </div>
        {{ $slot }}
    @endif
</div>
