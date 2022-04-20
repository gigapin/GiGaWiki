<x-app-layout>

    <x-actions-bar>
       
    </x-actions-bar>

    <x-create-form :model="'Users'">

        <p class="text-xl text-center">{{ $user->name }}</p>
        <p class="text-lg text-red-600 text-center">Are you sure you want delete this user?</p>

        <div class="mt-4 flex justify-center">
            <div class="py-4 mt-2 px-4">
                <a href="{{ route('users.show', $user->id) }}" class="w-32 bg-green-500 text-white md:w-32 rounded-md border-yellow-500  p-2 px-8 ring-2 ring-green-900 cursor-pointer">
                    Cancel
                </a>
            </div>
            <div class="py-4 px-4">
                <form action="{{ route('users.destroy', $user->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <input type="submit" value="Confirm" class="w-32 bg-green-500 text-white md:w-32 rounded-md border-yellow-500  p-2 ring-2 ring-green-900 cursor-pointer"/>
                </form>
            </div>
        </div>

    </x-create-form>

</x-app-layout>
