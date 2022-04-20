
<x-app-layout>

    <x-actions-bar>
        @include('partials.activity')
        @include('partials.visited')
    </x-actions-bar>

    <x-create-form :model="'Subjects'">

        @if (session()->has('success'))
            <x-alert :type="'success'" message="{{ session('success') }}" />
        @endif

        @if(count($bodies) < 1)
            @include('partials.unvailable')
        @else
            <div class="md:grid md:grid-cols-2 md:gap-2 2xl:grid 2xl:grid-cols-3">
                @can('update', App\Models\Subject::class)
                    @foreach($bodies as $item)
                        <x-cards title="{{ $item->name }}" body="{{ $item->description }}" slug="{{ $item->slug }}" :model="'subjects'"/>
                    @endforeach
                @elsecan('view', App\Models\Subject::class)
                    @foreach($bodies as $item)
                        <x-cards-guest title="{{ $item->name }}" body="{{ $item->description }}" slug="{{ $item->slug }}" :model="'subjects'"/>
                    @endforeach
                @endcan
            </div>
            <div class="px-4 mt-4">
                {{ $bodies->links() }}
            </div>
        @endif

    </x-create-form>

    @can('create', App\Models\Subject::class)
        <x-toolbar :link="'subjects.create'" :page="'New Subject'"/>
    @endcan

</x-app-layout>
