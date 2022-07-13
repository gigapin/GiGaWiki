<x-library-layout>

    <div class="w-full md:grid md:grid-cols-3 md:gap-8">  
        @foreach ($subjects as $item)
            <x-welcome-cards name="{{ $item->name }}" description="{{ $item->description }}" author="{{ $item->user->name }}" date="{{ $item->created_at }}" slug="{{ $item->slug }}" url="{{ route('library.show', $item->slug) }}"/>
        @endforeach

        {{ $subjects->links() }}
    </div>

</x-library-layout>