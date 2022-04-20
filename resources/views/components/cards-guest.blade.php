<div class="w-72 mx-auto my-3 py-4 px-8 bg-gradient-to-b from-green-300 to-green-200 border-b-4 border-green-600 rounded-lg shadow-xl md:w-80 lg:w-80 2xl:w-80">

    <div class="text-center">
        @if ($parent !== null)
            <a href="{{ route($model . '.show', $parent, $slug) }}" class="font-bold text-purple-700">{{ Str::limit($title, 20) }}</a>
        @else
            <a href="{{ route($model . '.show', $slug) }}" class="font-bold text-purple-700">{{ Str::limit($title, 20) }}</a>
        @endif
        <p class="font-bold text-gray-500 text-sm">{{ Str::limit($body, 20) }}</p>
    </div>

</div>
