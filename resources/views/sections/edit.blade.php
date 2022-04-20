<x-app-layout>

    <x-actions-bar>
        @include('partials.details')
    </x-actions-bar>

    <x-create-form :model="''">

        <form action="{{ route('sections.update', $slug->slug) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <x-breadcrumb route="{{ route('projects.show', $project->slug) }}" project="{{ $project->name }}" link="{{ route('sections.show', [$slug->project->slug, $slug->slug]) }}" name="{{ $slug->title }}" :value="'Update'" />

            <input type="hidden" name="project_id" value="{{ $slug->project_id }}">
            <x-input-title :label="'Title'" :name="'title'" value="{{ $slug->title }}" />
            <x-textarea :name="'description'" :label="'Description'" content="{{ $slug->description }}" />

        </form>
    </x-create-form>

    <x-buttons :delete="'true'" :link="'sections'" id="{{ $slug->slug }}"/>

</x-app-layout>
