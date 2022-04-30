<x-app-layout>

    <x-actions-bar></x-actions-bar>

    <x-create-form :model="''">

        

        <form action="{{ route('users.update', $user->slug) }}" method="POST" enctype="multipart/form-data">
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
                <h3>Edit Avatar</h3>
                @if ($user->image_id !== null)
                    <img src="{{ asset($image->url) }}" alt="" />
                @else
                    <i class="bi bi-person-square maxi-icons"></i>
                @endif
                
               
                    <x-input-file :name="'featured'" :label="'Select an avatar'" />
               
            </div>

            <div class="py-6 border-b border-gray-300">
                <h3>User Role</h3>
                <input type="text" name="roles" id="" value="{{ $role }}" readonly>
            </div>

            <div class="py-6 text-right">
                @if($user->id !== 1)
                    <x-link-button link="{{ route('users.delete', $user->id) }}" :label="'Delete User'" />
                @endif
                <x-button>Update User</x-button>
            </div>
            
        </form>
       
    </x-create-form>

</x-app-layout>
