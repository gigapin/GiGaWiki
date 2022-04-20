<x-app-layout>

    <x-actions-bar>

        @include('partials.details')
        @include('partials.activity')
        @include('partials.show-tags')

    </x-actions-bar>

    <x-create-form :model="''">

        @if (session()->has('success'))
            <x-alert :type="'success'" message="{{ session('success') }}" />
        @endif

        <x-breadcrumb link="{{ route('subjects.show', $slug->slug) }}" name="{{ $slug->name }}" :root="'subjects'" />

        <div class="py-4">
            <x-header-main-block title="{{ $slug->name }}" featured="{{ $featured }}" description="{{ $slug->description }}">
                @if ($slug->description !== null)
                    <div class="text-sm text-gray-700 my-4 px-4">
                        {!! $slug->description !!}
                    </div>
                @endif
            </x-header-main-block>

            @foreach($projects as $project)
                <x-list-main-block route="{{ route('projects.show', $project->slug) }}" name="{{ $project->name }}" />
            @endforeach
            
            <div class="px-4">
                {{ $projects->links() }}
            </div>
        </div>

    </x-create-form>

    @can(['update', 'delete'], App\Models\Subject::class)
        <x-buttons :delete="'true'" :edit="'true'" :link="'subjects'" id="{{ $slug->slug }}" :page="'New Project'" new="{{ route('projects.create') }}" />
    @elsecan('view', App\Models\Subject::class)
        <x-buttons :link="'subjects'" id="{{ $slug->slug }}" :page="'New Project'" new="{{ route('projects.create') }}" />
    @endcan

</x-app-layout>
