<x-app-layout>

    <x-actions-bar></x-actions-bar>

    <x-create-form :model="''">

        @include('partials.menu-settings')

        <form action="{{ route('users.store') }}" method="POST">
            @csrf

            <h1 class="text-center mb-0">Add New User</h1>

            <div class="py-6 border-b border-gray-300">
                <h3>User Details</h3>
                <p>
                    Set a display name and an email address for this user. The email address will be used for logging into the application.
                </p>
                <div class="md:flex md:justify-between">
                    <div class="w-full md:w-1/3 pr-6">
                        <p>Name</p>
                        <x-input type="text" name="name" />
                    </div>
                    <div class="w-full md:w-1/3 pr-6">
                        <p>Email</p>
                        <x-input type="text" name="email"/>
                    </div>
                    <div class="w-full md:w-1/3">
                        <p>Password</p>
                        <x-input type="password" name="password"/>
                    </div>
                </div>
            </div>

            <div class="py-6 border-b border-gray-300">
                <h3>User Roles</h3>
                <p>
                    Select which roles this user will be assigned to. 
                    If a user is assigned to multiple roles the permissions from those roles will stack and they will receive all abilities of the assigned roles.
                </p>
                <div class="py-1">
                    <input type="radio" name="roles[]" value="1" class="mr-2">Admin
                </div>
                <div class="py-1">
                    <input type="radio" name="roles[]" value="2" class="mr-2">Editor
                </div>
                <div class="py-1">
                    <input type="radio" name="roles[]" value="3" class="mr-2">Guest
                </div>
            </div>

            <div class="py-6 border-b border-gray-300">
                <h3>Send User Invite</h3>
                <p>
                    You can choose to send this user an invitation email. 
                </p>
                <div class="py-1">
                    <input type="checkbox" name="" class="mr-2">Send user invite email
                </div>
            </div>

            <div class="py-6 text-right">
                <x-button type="submit">Create New User</x-button>
            </div>
            
        </form>

    </x-create-form>

</x-app-layout>
