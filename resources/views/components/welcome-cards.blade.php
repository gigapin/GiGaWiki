<div class="mb-4 md:mb-0 rounded overflow-hidden shadow-lg bg-white">
    <!-- <img class="w-full" src="/img/card-top.jpg" alt="Sunset in the mountains"> -->
    <div class="px-6 py-4">
        <div class="font-bold text-xl mb-2">
            <a href="{{ $url }}">{{ $name }}</a>    
        </div>
        
        {{-- {{ $description }} --}}
        
    </div>
    <div class="px-6 pt-4 pb-2">
        <span class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2 mb-2">{{ $author }}</span>
        <span class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2 mb-2">{{ $date }}</span>
    </div>
</div>