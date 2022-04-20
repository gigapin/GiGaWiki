<x-app-layout>

    <x-actions-bar>

    </x-actions-bar>

        <x-create-form :model="'Projects'">
            <form action="{{ route('projects.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <x-breadcrumb link="{{ route('projects.index') }}" :name="'Projects'" :value="'Save'"/>
                <x-input-title :label="'Name'" :name="'name'" />
                <x-select :name="'subject_id'" :label="'Select a subject for this project'">
                    @foreach ($subjects as $subject)
                        <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                    @endforeach
                </x-select>
                <x-textarea :name="'description'" :label="'Description'" />
                <x-input-file :name="'featured'" :label="'Select an image'" />
                @include('partials.tag')
            </form>
        </x-create-form>

    <x-toolbar :link="'projects.index'" :page="'All Projects'" :icon="'false'"/>

</x-app-layout>

