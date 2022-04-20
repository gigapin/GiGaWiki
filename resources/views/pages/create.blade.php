<x-app-layout>

    <div class="w-11/12 mx-auto bg-white px-2 lg:w-10/12 lg:col-start-1 lg:col-end-5">


        <form action="{{ route('pages.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <x-breadcrumb route="{{ route('projects.show', $project->slug) }}" project="{{ $project->name }}" link="{{ route('sections.show', [$section->project->slug, $section->slug]) }}" name="{{ $section->title }}" :value="'Save'"/>

            <input type="hidden" name="section_id" value="{{ $section->id }}">
            <input type="hidden" name="project_id" value="{{ $project->id }}">
            @error('title')
                <p class="text-base text-gray-300">{{ $message }}</p>
            @enderror
            <input type="text" name="title" placeholder="Title" class="w-full mx-0 py-2 pl-2 border-l-0 border-r-0 text-3xl @error('title') border-3 border-red-600 @enderror">

            @error('content')
                <p class="text-base text-gray-300">{{ $message }}</p>
            @enderror
            <textarea name="content" id="post" class="w-full h-screen py-4 border-l-0 border-r-0 @error('content') border-3 border-red-600 @enderror overscoll-y-contain"></textarea>

            @include('partials.tag')

        </form>
    </div>

</x-app-layout>
