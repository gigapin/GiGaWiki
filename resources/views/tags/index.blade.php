<x-app-layout>
    <div class="w-11/12 mx-auto bg-white p-2 lg:p-4 lg:w-6/12 lg:col-start-1 lg:col-end-5 rounded-md">
        <p class="text-xl font-bold py-2">Tags</p>
        @foreach($tags as $key => $tag)
            <div class="flex justify-between border-b border-gray-200">
                <div class="pt-3">
                    <i class="bi bi-tag mr-1"></i>
                    <a href="{{ route('tags.show', $key) }}">{{ $key }} {{ $tag }}</a> 
                </div>
            </div>
        @endforeach
    </div>
</x-app-layout>
