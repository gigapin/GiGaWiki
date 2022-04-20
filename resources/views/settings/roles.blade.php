<x-app-layout>

    <x-actions-bar></x-actions-bar>

    <x-create-form :model="''">

        @include('partials.menu-settings')

            <h1 class="text-center">User Roles</h1>

            @foreach ($roles as $role)
                <div class="flex items-stretch py-4 border-b border-gray-200">
                    <div class="mr-24 font-bold">{{ $role->name }}</div>
                    <div>{{ $role->description }}</div>
                </div>
            @endforeach

    </x-create-form>
    
    <x-toolbar />

</x-app-layout>