<x-library-layout>

    <div class="w-full md:grid md:grid-cols-3 md:gap-8">  
        @foreach ($projects as $item)
            <x-welcome-cards 
                name="{{ $item->name }}" 
                description="{{ $item->description }}" 
                author="{{ $item->user->name }}" 
                date="{{ $item->created_at }}" 
                slug="{{ $item->slug }}" 
                url="{{ route('document', $item->slug) }}" 
            />
        @endforeach
    </div>

</x-library-layout>