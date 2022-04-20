<x-app-layout>

    <x-actions-bar>

    </x-actions-bar>

        <x-create-form :model="'Sections'">

            <form action="{{ route('sections.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <x-breadcrumb link="{{ route('projects.show', $project->slug) }}" name="{{ $project->name }}" :value="'Save Page'"/>

                <x-input-title :label="'Title'" :name="'title'" />

                <input type="hidden" value="{{ $project->id }}" name="project_id"/>

                <x-textarea :name="'description'" :label="'Description'" />

            </form>

       </x-create-form>

    <x-toolbar :link="'projects.index'" :page="'Projects'" :icon="'false'"/>

</x-app-layout>
