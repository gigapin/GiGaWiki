<x-app-layout>

    <x-toolbar :link="'lectures.create'" $id="{{ $id }}" :page="'New Lecture'"/>
    <x-actions-bar filter="$filter"/>

    <x-create-form :model="'Lectures'">

        @if(count($bodies) < 1)
            @include('partials.unvailable')
        @else
            <div class="w-full mx-2 my-2">

                <p class="text-2xl md:text-3xl xl:text-4xl font-bold">{{ $project->name }}</p>

                <div class="text-sm text-gray-700 my-4">{{ $project->description }}</div>

                <div class="w-full lg:flex flex-wrap">

                    <ul class="mt-4">
                        @foreach($bodies as $item)
                            <li class="bg-gradient-to-r from-green-500 text-gray-200 lg:text-lg border-l-4 border-yellow-700 pl-2 py-2 lg:py-4 my-2">
                                {{--<a href="{{ route('pages.show', [$project->id,  $section->id]) }}">--}}
                                    {{ $item->title }}
                                {{--</a>--}}
                            </li>
                        @endforeach
                    </ul>

                </div>
            </div>
        @endif

    </x-create-form>

</x-app-layout>


