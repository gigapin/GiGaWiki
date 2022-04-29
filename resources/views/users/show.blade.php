<x-app-layout>

    <x-actions-bar></x-actions-bar>

    <x-create-form :model="''">

        <div class="">

            <h2>User Details</h2>
            <div class="p-4 border border-gray-300 flex justify-between">
                
                <div>
                @if ($user->image_id !== null)
                    <img src="{{ $user->image->url }}" alt="" class="rounded-full h-32 w-32 border border-gray-300"/>
                @else
                    <i class="bi bi-person-square maxi-icons"></i>
                @endif
                </div>
                {{-- User data --}}
                <div>
                    <ul class="list-none">
                        <li>{{ $user->name }}</li>
                        <li>{{ $user->email }}</li>
                    </ul>
                </div>
                {{-- Details --}}
                <div>
                    <ul class="list-none">
                        <li><strong>Created at:</strong> {{ $user->created_at }}</li>
                        <li><strong>Last updated at:</strong> {{ $user->updated_at }}</li>
                    </ul>
                </div>
            </div>     

            {{-- Created Content --}}
            <h2>Created Content</h2>
            <div class="p-4 border border-gray-300 flex justify-between">
                {{-- Subjects --}}
                <div>
                    <span> 
                        <i class="bi bi-journal-check icons mr-2"></i>Subjects created
                        <div class="rounded-full h-6 w-6 flex items-center justify-center bg-green-500 text-white">{{ $subject }}</div>
                    </span>
                </div>
                {{-- Projects --}}
                <div>
                    <i class="bi bi-file-earmark-ppt icons mr-2"></i>Projects created
                    <div class="rounded-full h-6 w-6 flex items-center justify-center bg-blue-500 text-white">{{ $project }}</div>
                </div>
                {{-- Sections --}}
                <div>
                    <i class="bi bi-journal-check icons mr-2"></i>Pages created
                    <div class="rounded-full h-6 w-6 flex items-center justify-center bg-red-500 text-white">{{ $page }}</div>
                </div>
                {{-- Pages --}}
                <div>
                    <i class="bi bi-file-font-fill icons mr-2"></i>Pages updated
                    <div class="rounded-full h-6 w-6 flex items-center justify-center bg-red-700 text-white">{{ $page_updated }}</div>
                </div>
            </div>

            <h2>Edit / Remove Profile</h2>
            <div class="p-4 border border-gray-300 flex justify-around">
                <div>
                    <x-link-button link="{{ route('users.edit', $user->slug) }}" :label="'Edit Profile'" />
                </div>
                <div>
                    <x-link-button link="{{ route('users.delete', $user->id) }}" :label="'Remove User'" />
                </div>
            </div>

        </div>

    </x-create-form>

</x-app-layout>