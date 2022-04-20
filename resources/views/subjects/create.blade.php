<x-app-layout>

    <x-actions-bar>

    </x-actions-bar>

    <x-create-form :model="'Subject'">

        <form action="{{ route('subjects.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <x-breadcrumb link="{{ route('subjects.index') }}" :name="'Subjects'" :value="'Save'"/>
            
            <x-input-title :label="'Name'" :name="'name'" />
            <x-textarea :name="'description'" />
            <x-input-file :name="'featured'" :label="'Select an image'" />
            @include('partials.tag')

        </form>

    </x-create-form>

    <x-toolbar :link="'subjects.index'" :page="'All Subjects'" :icon="'false'"/>

</x-app-layout>
