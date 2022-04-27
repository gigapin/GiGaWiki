<x-guest-layout>
    <x-actions-bar>
       
    </x-actions-bar>

    <x-create-form :model="''">

        <p class="text-xl text-center">{{ $user->name }}</p>
        <p class="text-lg text-red-600 text-center">We send you an email to verify your email addreess.</p>
        <p class="text-md text-red-600 text-center">Please check your email to access to your dashboard.</p>

        

    </x-create-form>
</x-guest-layout>