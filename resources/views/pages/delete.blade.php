<x-app-layout>

    <div class="w-11/12 lg:w-8/12 mt-4 mx-auto bg-white rounded-md text-center">
        <p class="text-xl">{{ $page->title }}</p>
        <p class="text-lg text-red-600">Are you sure you want delete this page?</p>

        <div class="mt-4 flex justify-center">
            <div class="py-4 mt-2 px-4">
                <a href="{{ route('pages.show', $page->slug) }}" class="w-32 bg-green-500 text-white md:w-32 rounded-md border-yellow-500  p-2 px-8 ring-2 ring-green-900 cursor-pointer">
                    Cancel
                </a>
            </div>
            <div class="py-4 px-4">
                <form action="{{ route('pages.delete', $page->slug) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <input type="hidden" name="section_id" value="{{ $page->section_id }}">
                    <input type="hidden" name="project_id" value="{{ $page->project_id }}">
                    <input type="submit" value="Confirm" class="w-32 bg-green-500 text-white md:w-32 rounded-md border-yellow-500  p-2 ring-2 ring-green-900 cursor-pointer"/>
                </form>
            </div>
        </div>
    </div>

</x-app-layout>
