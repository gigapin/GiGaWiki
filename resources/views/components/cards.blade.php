<div class="w-11/12 mx-auto my-3 py-4 px-8 bg-gradient-to-b from-green-300 to-green-200 border-b-4 border-green-600 rounded-lg shadow-xl md:w-80 lg:w-80 2xl:w-80">

    
    <div class="text-center">
        @if ($parent !== null)
            <a href="{{ route($model . '.show', $parent, $slug) }}" class="font-bold text-purple-700">{{ Str::limit($title, 20) }}</a>
        @else
            <a href="{{ route($model . '.show', $slug) }}" class="font-bold text-purple-700">{{ Str::limit($title, 20) }}</a>
        @endif
        <p class="font-bold text-gray-500 text-sm">{{ $body }}</p>
    </div>

    <div class="w-11/12 mx-auto pt-4 pb-2 h-12 text-xs flex justify-between lg:w-8/12 ">

        <div class="w-full">
            <span class="py-1 font-semibold text-indigo-700 mr-2 mb-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-pencil-square float-left" viewBox="0 0 16 16">
                    <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                    <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                </svg>
                <a href="{{ route($model . '.edit', $slug) }}" class="ml-2">Edit</a>
            </span>
        </div>

        <div class="w-full">
            <span class="py-1 font-semibold text-red-700 mr-2 mb-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-x-square float-left" viewBox="0 0 16 16">
                    <path d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"/>
                    <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
                </svg>
                <a href="{{ route($model . '.destroy', $slug) }}" class="ml-2">Delete</a>
            </span>
        </div>

    </div>

</div>
