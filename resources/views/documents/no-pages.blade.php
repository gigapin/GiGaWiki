<x-guest-layout>

    <div class="w-11/12 lg:w-8/12 mt-4 mx-auto bg-white rounded-md text-center">
        <p class="text-xl">No posts have been written yet!</p>
        <p class="text-lg text-red-600">You need be logged to create a page.</p>

        <div class="mt-4 flex justify-center">
            <div class="py-4 mt-2 px-4">
                <a href="{{ route('login') }}" class="w-32 bg-green-500 text-white md:w-32 rounded-md border-yellow-500  p-2 px-8 ring-2 ring-green-900 cursor-pointer">
                    Login
                </a>
            </div>
            <div class="py-4 mt-2 px-4">
                <a href="{{ route('library.show', $subject->slug) }}" class="w-32 bg-green-500 text-white md:w-32 rounded-md border-yellow-500  p-2 px-8 ring-2 ring-green-900 cursor-pointer">
                    Back
                </a>
            </div>
        </div>
    </div>

</x-guest-layout>
