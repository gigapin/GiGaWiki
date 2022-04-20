<x-app-layout>
    <div class="w-11/12 mx-auto bg-white p-2 lg:p-4 lg:w-6/12 lg:col-start-1 lg:col-end-5">
        <p class="text-xl font-bold py-2">My Favorites</p>
        @foreach($favorites as $row)
            <div class="flex justify-between border-b border-gray-200">
                <div class="pt-3">
                    <a href="{{ route('pages.show', $row->page->slug) }}">{{ $row->page->title }}</a>
                </div>
                <div>
                    <form action="{{ route('favorites.delete', $row->id) }}" method="post">
                        @csrf
                        @method('DELETE')
                        <span>
                            <i class="bi bi-star-fill icons"></i>
                            <button type="submit" class="text-xs md:text-sm xl:text-base h-12">Unfavorite</button>
                        </span>
                    </form>
                </div>
            </div>
        @endforeach
    </div>
</x-app-layout>
