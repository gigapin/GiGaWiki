<x-guest-layout>

    <x-actions-bar>
       
    </x-actions-bar>

    <x-create-form :model="''">

        <p class="text-xl text-center">{{ $user->name }}</p>
        <p class="text-lg text-red-600 text-center">Thank you for to accept our invitation!</p>
        <p class="text-md text-red-600 text-center">Please click button below to confirm your email address.</p>

        <div class="mt-4 flex justify-center">
            <div class="py-4 mt-2 px-4">
                <a href="{{ route('email.verify.invitation', $user->id) }}" class="w-32 bg-green-500 text-white md:w-32 rounded-md border-yellow-500  p-2 px-8 ring-2 ring-green-900 cursor-pointer">
                    Confirm your email
                </a>
            </div>
        </div>

    </x-create-form>

</x-guest-layout>
