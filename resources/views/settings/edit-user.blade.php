<x-app-layout>

    <x-actions-bar></x-actions-bar>

    <x-create-form :model="''">

        @include('partials.menu-settings')

        <form action="{{ route('settings.users.update', $user->slug) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PATCH')

            <h1 class="text-center mb-0">Edit User</h1>

            <div class="py-6 border-b border-gray-300">
                <h3>User Details</h3>
                <p>
                    Set a display name and an email address for this user. The email address will be used for logging into the application.
                </p>
                <div class="md:flex md:justify-between">
                    <div class="w-full md:w-1/3 pr-6">
                        <p>Name</p>
                        <x-input type="text" name="name" value="{{ $user->name }}" />
                    </div>
                    <div class="w-full md:w-1/3 pr-6">
                        <p>Email</p>
                        <x-input type="text" name="email" value="{{ $user->email }}" />
                    </div>
                    <div class="w-full md:w-1/3">
                        <p>Password</p>
                        <x-input type="password" name="password" />
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
                    <input type="radio" name="roles[]" value="1" class="mr-2" @if($role === 'Admin')checked @endif>Admin
                </div>
                <div class="py-1">
                    <input type="radio" name="roles[]" value="2" class="mr-2" @if($role === 'Editor')checked @endif>Editor
                </div>
                <div class="py-1">
                    <input type="radio" name="roles[]" value="3" class="mr-2" @if($role === 'Guest')checked @endif>Guest
                </div>
            </div>

            <div class="py-6 border-b border-gray-300">
                <h3>Edit Avatar</h3>
                @if ($avatar !== null)
                    <img src="{{ asset($avatar->url) }}" alt="" width="150px" height="150px" />
                @else
                    <i class="bi bi-person-square maxi-icons"></i>
                @endif
                
                @if($showUploadAvatar === true)
                    <x-input-file :name="'featured'" :label="'Select an avatar'" />
                @endif
            </div>

            <div class="py-6 text-right">
                <x-link-button link="{{ route('users.delete', $user->id) }}" :label="'Delete User'" />
                <x-button>Update User</x-button>
            </div>
            
        </form>
       
    </x-create-form>

</x-app-layout>
