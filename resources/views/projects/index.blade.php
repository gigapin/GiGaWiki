<x-app-layout>

    <x-actions-bar>
        @include('partials.activity')
        @include('partials.visited')
    </x-actions-bar>

    <x-create-form :model="'Projects'">

        @if (session()->has('success'))
            <x-alert :type="'success'" message="{{ session('success') }}" />
        @endif

        @if(count($projects) < 1)
            @include('partials.unvailable')
        @else
            <div class="md:grid md:grid-cols-2 md:gap-2 2xl:grid 2xl:grid-cols-3">
                @foreach($projects as $item)
                    <x-cards title="{{ $item->name }}" body="{{ $item->description }}" slug="{{ $item->slug }}" :model="'projects'" />
                @endforeach
            </div>
            <div class="px-4 mt-4">
                {{ $projects->links() }}
            </div>
        @endif

    </x-create-form>

    <x-toolbar :link="'projects.create'" :page="'New Project'" />

</x-app-layout>

