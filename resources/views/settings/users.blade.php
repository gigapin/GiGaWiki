<x-app-layout>

    <x-actions-bar></x-actions-bar>

    <x-create-form :model="''">

        @if(session()->has('success')) 
            <x-alert :type="'success'" message="{{ session('success') }}"/>
        @endif

        @include('partials.menu-settings')

        <h1 class="text-center mb-0">Users</h1>

        @foreach ($users as $user)
            <div class="flex border-b border-gray-200 py-6">
                <div class="flex-none w-12 mr-4">
                    @if($user->image_id !== null)
                        @foreach ($avatars as $avatar)
                            @if($avatar->id === $user->image_id)
                                <img src="{{ asset($avatar->url) }}" alt="" class="rounded-full h-12 w-12 border border-gray-300">
                                @endif
                       @endforeach 
                    @else
                        <i class="bi bi-person-circle icons"></i>
                    @endif
                </div>
                <div class="flex-grow">
                    <div>
                        <a href="{{ route('settings.users.edit', $user->slug) }}">{{ $user->name }}</a>
                    </div>
                    <div>
                        <a href="mailto:{{ $user->email }}">{{ $user->email }}</a>
                    </div>
                </div>
                <div class="flex-none w-16">
                    @foreach($user->roles as $role)
                        {{ $role->name }}
                    @endforeach
                </div>
            </div>
        @endforeach

        <div class="py-6 text-right">
            <x-link-button link="{{ route('users.create') }}" :label="'Add New User'" />
        </div>

    </x-create-form>

    <x-toolbar />

</x-app-layout>
