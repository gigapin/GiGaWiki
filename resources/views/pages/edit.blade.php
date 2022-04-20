<x-app-layout>

    <div class="w-11/12 mx-auto bg-white px-2 lg:w-10/12 lg:col-start-1 lg:col-end-5">

        <form action="{{ route('pages.update', $page->slug) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <x-breadcrumb route="{{ route('projects.show', $project->slug) }}" project="{{ $project->name }}" link="{{ route('sections.show', [$project->slug, $section->slug]) }}" name="{{ $section->title }}" :value="'Update Page'"/>

            <input type="hidden" name="section_id" value="{{ $section->id }}">
            <input type="hidden" name="project_id" value="{{ $project->id }}">
            <input type="text" name="title" placeholder="Title" class="w-full mx-0 py-4 border-l-0 border-r-0 text-2xl font-semibold" value="{{ $page->title }}">
            <textarea name="content" id="post" class="w-full h-screen py-4 border-l-0 border-r-0">
                {{ $page->content }}
            </textarea>
            @if(count($tags) > 0)
                @foreach($tags as $tag)
                    <input type="text" name="edit[][{{ $tag->id }}]" class="w-full py-1 px-2 border-2 border-gray-200 mt-2 input-tag" value="{{ $tag->name }}">
                @endforeach
            @endif
            @include('partials.tag')
        </form>

    </div>

</x-app-layout>
