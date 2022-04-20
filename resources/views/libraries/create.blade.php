<x-app-layout>

    <div class="container">
        <form action="{{ route('libraries.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <x-actions-bar />
            <x-inputs type="file" label="Upload File" name="name" />
        </form>
    </div>

</x-app-layout>
