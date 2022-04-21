<x-app-layout>

    <x-actions-bar :filter="'true'">

        @include('partials.details')

        @if($subject !== null)
            <div class="w-full mt-0 mb-8">
                <p class="font-semibold text-xl mt-0">Subject</p>
                <i class="bi bi-collection float-left mr-2 mini-icons"></i>
                <a href="{{ route('subjects.show', $subject->slug) }}" class="text-sm font-extrabold">{{ $subject->name }}</a>
            </div>
        @endif

        @include('partials.show-tags')
        @include('partials.activity')
        @include('partials.visited')

    </x-actions-bar>

    <x-create-form :model="''">

        @if (session()->has('success'))
            <x-alert :type="'success'" message="{{ session('success') }}" />
        @endif

        <x-breadcrumb link="{{ route('projects.show', $slug->slug) }}" name="{{ $slug->name }}"/>

        <div class="py-4">
            <x-header-main-block description="{{ $slug->description }}" title="{{ $slug->name }}" featured="{{ $featured }}">
                @if ($slug->description !== null)
                    <div class="text-sm text-gray-700 my-4 px-4">
                        {!! $slug->description !!}
                    </div>
                @endif
            </x-header-main-block>

            @foreach($sections as $section)
                <x-list-main-block route="{{ route('sections.show', [$slug->slug,  $section->slug]) }}" name="{{ $section->title }}" />
            @endforeach

            <div class="px-4">
                {{ $sections->links() }}
            </div>
        </div>
        
        @if($displayComments === 'false')
            @include('partials.comments')
        @endif

    </x-create-form>

    <x-buttons :edit="'true'" :delete="'true'" :link="'projects'" id="{{ $slug->slug }}" :page="'Add Section'" new="{{ route('sections.create', $slug->slug) }}">
        
    </x-buttons>

</x-app-layout>
