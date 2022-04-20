<x-app-layout>

    <x-actions-bar :filter="'true'">
        @include('partials.details')
        @include('partials.activity')
    </x-actions-bar>

    <x-create-form :model="''">
        @if (session()->has('success'))
            <x-alert :type="'success'" message="{{ session('success') }}" />
        @endif

        <x-breadcrumb route="{{ route('projects.show', $slug->project->slug) }}" project="{{ $slug->project->name }}" link="{{ route('sections.show', [$slug->slug, $slug->slug]) }}" name="{{ $slug->title }}" />

        <div class="py-4">
            <x-header-main-block title="{{ $slug->title }}">
                @if ($slug->description !== null)
                    <div class="text-sm text-gray-700 my-4 px-4">
                        {!! $slug->description !!}
                    </div>
                @endif
            </x-header-main-block>

            @foreach($pages as $item)
                <x-list-main-block route="{{ route('pages.show', $item->slug) }}" name="{{ $item->title }}" />
            @endforeach
            
            <div class="px-4">
                {{ $pages->links() }}
            </div>
        </div>

        @include('partials.comments')
    </x-create-form>

    <x-buttons :link="'sections'" id="{{ $slug->slug }}" :page="'New Page'" new="{{ route('pages.create', [$slug->project->slug, $slug->slug]) }}" :delete="'true'" :edit="'true'"/>

</x-app-layout>
