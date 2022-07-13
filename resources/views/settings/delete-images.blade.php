<x-app-layout>

    <x-actions-bar></x-actions-bar>

    <x-create-form :model="''">

        @include('partials.menu-settings')
            
            @if(count($images) > 0)
                <p class="text-xl text-center">Delete all images</p>
                <p class="text-lg text-red-600 text-center">Are you sure you want delete permanently all images from database?</p>

                <div class="mt-4 flex justify-center">
                    <div class="py-4 mt-2 px-4">
                        <a href="{{ route('settings.maintenance') }}" class="w-32 bg-green-500 text-white md:w-32 rounded-md border-yellow-500  p-2 px-8 ring-2 ring-green-900 cursor-pointer">
                            Cancel
                        </a>
                    </div>
                    <div class="py-4 px-4">
                        <form action="{{ route('settings.cleanup-images') }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <input type="submit" value="Confirm" class="w-32 bg-green-500 text-white md:w-32 rounded-md border-yellow-500  p-2 ring-2 ring-green-900 cursor-pointer"/>
                        </form>
                    </div>
                </div>
            @else
                @if($files > 0)
                    <p>Do you want force delete image files?</p>
                    <form action="{{ route('settings.force.cleanup.images') }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <input type="submit" value="Confirm" class="w-32 bg-green-500 text-white md:w-32 rounded-md border-yellow-500  p-2 ring-2 ring-green-900 cursor-pointer"/>
                    </form>
                @else
                    <p class="text-xl text-center">No images to delete</p>
                @endif
            @endif

        
    </x-create-form>
    <x-toolbar />

</x-app-layout>
