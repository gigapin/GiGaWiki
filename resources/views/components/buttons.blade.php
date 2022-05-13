<div class="absolute top-36 flex flex-justify-between w-full z-0 xl:static xl:block xl:row-start-1 xl:ml-4 xl:w-72 2xl:ml-0 xl:mb-4 2xl:w-80" id="last-box">

    {{-- Add Button--}}
    @if ($new !== null && $page !== null)
        <div class="p-2 ml-2 mr-1 w-1/3 lg:mx-auto lg:p-2 lg:w-10/12 lg:ml-0 lg:mb-2 2xl:w-8/12 2xl:mx-auto">
            <a href="{{ $new }}" class="text-xs md:text-sm xl:text-base h-12">
                <i class="bi bi-plus-square icons"></i>
                {{ $page }}
            </a>
        </div>
    @endif

    {{-- Edit Button --}}
    @if($edit === true)
        <div class="p-2 @if($delete !== true) mx-2 @else mx-1 @endif w-1/3 lg:mx-auto lg:p-2 lg:mb-2 lg:w-10/12 lg:ml-0 2xl:w-8/12 2xl:mx-auto">
            <a href="{{ route($link . '.edit', $id) }}" class="text-xs md:text-sm xl:text-base">
                <i class="bi bi-pencil-square icons"></i>
                Edit
            </a>
        </div>
    @endif

    {{-- Delete Button --}}
    @if($delete === true)
        <div class="p-2 mr-2 w-1/3 @if($edit !== true) ml-2 @else ml-1 @endif lg:mx-auto lg:p-2 lg:mb-2 lg:w-10/12 lg:ml-0 2xl:w-8/12 2xl:mx-auto">
            <a href="{{ route($link . '.destroy', $id) }}" class="text-xs md:text-sm xl:text-base">
                <i class="bi bi-x-square icons"></i>
                Delete
            </a>
        </div>
    @endif

    {{ $slot }}

</div>


