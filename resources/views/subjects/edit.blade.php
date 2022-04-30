<x-app-layout>

    <x-actions-bar>
        @include('partials.details')
    </x-actions-bar>

    <x-create-form :model="''">
        
        <form action="{{ route('subjects.update', $slug->slug) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PATCH')

            <x-breadcrumb :root="'subjects'" link="{{ route('subjects.show', $slug->slug) }}" name="{{ $slug->name }}" :value="'Update'" />

            <x-input-title :label="'Name'" :name="'name'" value="{{ $slug->name }}" />
            <x-textarea :name="'description'" :label="'Description'" content="{{ $slug->description }}" />
            @if ($featured !== '')
                <img src="{{ $featured }}" alt="" />
                <input type="hidden" name="image_id" value="{{ $slug->image_id }}">
            @endif
            <x-input-file :name="'featured'" :label="'Select an image'" />
            
            @include('partials.tag')

        </form>

        @include('partials.tags')

    </x-create-form>

    <x-buttons :delete="'true'" :link="'subjects'" id="{{ $slug->slug }}"/>

</x-app-layout>

