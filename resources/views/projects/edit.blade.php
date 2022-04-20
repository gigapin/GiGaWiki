<x-app-layout>

    <x-actions-bar>
        @include('partials.activity')
    </x-actions-bar>

    <x-create-form :model="''">
        
        <form action="{{ route('projects.update', $slug->slug) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PATCH')

            <x-breadcrumb link="{{ route('projects.show', $slug->slug) }}" name="{{ $slug->name }}" :value="'Update'" />
            
            <x-input-title :label="'Name'" :name="'name'" value="{{ $slug->name }}"/>
            <x-select :name="'subject_id'" :label="'Select a subject for this project'">
                @foreach ($subjects as $subject)
                    @if ($subject->id === $slug->subject_id)
                        <option value="{{ $subject->id }}" selected>
                            {{ $subject->name }}
                        </option>
                    @else
                        <option value="{{ $subject->id }}">
                            {{ $subject->name }}
                        </option>
                    @endif
                @endforeach
            </x-select>
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

    <x-buttons :delete="'true'" :link="'projects'" id="{{ $slug->slug }}"/>

</x-app-layout>
