<x-app-layout>

    <x-actions-bar>
        <div class="w-full mt-0 mb-4">
            <p class="text-green-200 font-semibold text-xl mt-0">Details</p>
            <div class="mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-plus-square float-left mr-2 text-green-400" viewBox="0 0 16 16">
                    <path d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"/>
                    <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
                </svg>
                <p class="text-gray-300 text-sm">Created {{ Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $section->created_at)->diffForHumans() }} by {{ $user->name }}</p>
            </div>

            @if($section->created_at != $section->updated_at)
                <div class="my-4">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-pencil-square float-left mr-2 text-green-400" viewBox="0 0 16 16">
                        <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                        <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                    </svg>
                    <p class="text-gray-300 text-sm">Updated {{ Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $section->updated_at)->diffForHumans() }} by {{ $user->name }}</p>
                </div>
            @endif
        </div>
    </x-actions-bar>

  <x-create-form :model="'Section'">
        <p class="text-xl text-center">{{ $section->title }}</p>
        <p class="text-lg text-red-600 text-center">Are you sure you want delete this lecture?</p>

        <div class="mt-4 flex justify-center">
            <div class="py-4 mt-2 px-4">
                <a href="{{ route('sections.show', [$section->project->slug, $section->slug]) }}" class="w-32 bg-green-500 text-white md:w-32 rounded-md border-yellow-500  p-2 px-8 ring-2 ring-green-900 cursor-pointer">
                    Cancel
                </a>
            </div>
            <div class="py-4 px-4">
                <form action="{{ route('sections.destroy', [$section->slug]) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <input type="submit" value="Confirm" class="w-32 bg-green-500 text-white md:w-32 rounded-md border-yellow-500  p-2 ring-2 ring-green-900 cursor-pointer"/>
                </form>
            </div>
        </div>
  </x-create-form>

    <x-buttons :link="'sections'" id="{{ $section->slug }}" :delete="'false'" />

</x-app-layout>
