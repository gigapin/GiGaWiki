@if(count($tags) > 0)
    <div class="py-4">
        @foreach($tags as $tag)
            <form action="{{ route('tags.delete', $tag->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <input type="text" name="edit[][{{ $tag->id }}]" class="w-full py-1 px-2 border-2 border-gray-200 mt-2 input-tag" value="{{ $tag->name }}">
                <button type="submit">
                    <i class="bi bi-x mini-icons"></i>
                </button>
            </form>
        @endforeach
    </div>
@endif


