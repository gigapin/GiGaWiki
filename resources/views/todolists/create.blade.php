<x-app-layout>

  <x-actions-bar>

  </x-actions-bar>

    <x-create-form :model="'ToDoList'">
      <form action="{{ route('todolists.store') }}" method="POST">
        @csrf
        <x-breadcrumb link="{{ route('todolists.index') }}" :name="'ToDoList'" :value="'Add'"/>
        <x-input-title :label="'Title'" :name="'title'" />
        <input type="checkbox" name="status" />Not Started
        <input type="checkbox" name="status" />In Progress
        <input type="checkbox" name="status" />Completed
        <x-textarea :name="'description'" :label="'Description'" />
       
      </form>
    </x-create-form>

  <x-toolbar :link="'projects.index'" :page="'All Projects'" :icon="'false'"/>

</x-app-layout>