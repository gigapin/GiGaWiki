<div class="p-2 ml-2 mr-1 w-1/3 lg:mx-auto lg:p-2 lg:w-10/12 lg:ml-0 lg:mb-2 2xl:w-8/12 2xl:mx-auto">
    @if($favorite !== null)
        <form action="{{ route('favorites.delete', $favorite->id) }}" method="post">
            @csrf
            @method('DELETE')
            <i class="bi bi-star-fill icons border-gray-800"></i>
            <button type="submit" id="favorite-delete" class="text-xs md:text-sm xl:text-base h-12">Unfavorite</button>
        </form>
    @else
        <form action="{{ route('favorites.store') }}" method="post">
            @csrf
            <input type="hidden" name="page_type" value="{{ $url }}">
            <input type="hidden" name="page_id" value="{{ $slug->id }}">
            <i class="bi bi-star border-2 border-gray-600 radius-xl px-0.5 text-md"></i>
            <button type="submit" id="favorite-store" class="text-xs md:text-sm xl:text-base h-12">Favorite</button>
        </form>
    @endif
</div>

