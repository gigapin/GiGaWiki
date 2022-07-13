<x-app-layout>

    <x-actions-bar></x-actions-bar>

    <x-create-form :model="''">

        @include('partials.menu-settings')
            <p class="text-xl font-bold py-2">Recycle Bin</p>

            <div class="">
                <form action="{{ route('settings.empty-bin') }}" method="post">
                    @csrf
                    @method('DELETE')
                    <x-button type="submit">Empty Recycle Bin</x-button>
                </form>
            </div>
            @foreach($pages as $row)
                <div class="flex justify-between border-b border-gray-200 py-2">
                    <div>
                        <i class="bi bi-file-code mini-icons"></i>
                        {{ $row->title }}
                    </div>
                    <div>
                        <i class="bi bi-person mini-icons"></i>
                        {{ $user->name }}
                    </div>
                    <div>
                        <i class="bi bi-alarm mini-icons"></i>  
                        {{ $row->deleted_at }}
                    </div>
                    <div> 
                        <div class="flex flex-row">
                            <div class="mx-4">
                                <a href="{{ route('settings.restore', $row->id) }}">Restore</a>
                            </div>
                            <div>
                                <form action="{{ route('settings.force-delete', $row->id) }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit">Delete</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

    </x-create-form>
    <x-toolbar />

</x-app-layout>