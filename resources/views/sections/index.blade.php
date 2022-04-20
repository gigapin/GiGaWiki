<x-app-layout>

    <x-toolbar :link="'sections.create'" :id="'0'"  :page="'New Section'" />
    <x-actions-bar :filter="'true'" />

    <x-create-form :model="'Sections'">

        @if(count($bodies) < 1)
            @include('partials.unvailable')
        @else
            <div class="w-full lg:flex flex-wrap">
                @foreach($bodies as $item)
                    <x-cards title="{{ $item->title }}" body="{{ $item->description }}" slug="{{ $item->slug }}" id="{{ $item->id }}" :model="'sections'" parent="{{ $item->project_id }}" />
                @endforeach
            </div>
        @endif

    </x-create-form>

</x-app-layout>
