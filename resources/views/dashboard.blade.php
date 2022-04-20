<x-app-layout>

    <x-actions-bar>
        @include('partials.dashboard-visited')
    </x-actions-bar>

    <x-create-form :model="''">
        <div class="mb-4">
            <p class="font-bold text-xl text-center">Latest Projects Updated</p>
            <div class="md:grid md:grid-cols-2 md:gap-2 2xl:grid 2xl:grid-cols-3">
                @forelse($project_latest as $project)
                    <x-cards title="{{ $project->name }}" body="{{ $project->description }}" slug="{{ $project->slug }}" :model="'projects'" />
                @empty
                    <p>{{ __('No activity yet') }}</p>
                @endforelse
            </div>
        </div>
        <div class="mb-4">
            <p class="font-bold text-xl text-center">Latest pages Updated</p>
            <div class="md:grid md:grid-cols-2 md:gap-2 2xl:grid 2xl:grid-cols-3">
                @forelse($pages as $page)
                    <x-cards title="{{ $page->title }}" body="{{ $page->body }}" slug="{{ $page->slug }}" :model="'pages'" />
                @empty
                    <p>No page has been created yet.</p>
                @endforelse
            </div>
        </div>
    </x-create-form>

    
    <x-toolbar :link="'projects.create'" :page="'New Project'" />

</x-app-layout>

