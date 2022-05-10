<x-app-layout>

    <x-actions-bar :filter="'true'">
        <div class="w-full md:text-left pb-0 mb-0 mt-0">
            <p class="font-semibold text-xl mt-0">Project Navigation</p>
            <div class="border-l-4 border-red-600 px-2">
                <p class="text-gray-600 font-semibold text-lg">{{ $project->name }}</p>
            </div>
            <div class="border-l-4 border-red-800 px-2">
                <ul class="list-none text-sm ml-0 pl-2">
                    @foreach($all_sections as $one_section)
                        <li class="pt-4">
                            <a href="{{ route('sections.show', [$project->slug, $one_section->slug]) }}" class="text-gray-600 text-base">{{ $one_section->title }}</a>
                            <ul class="mt-0 list-none mb-0 pb-0">
                                @foreach($pages as $nav_page)
                                    @if($nav_page->section_id === $one_section->id)
                                        <li class="border-l-4 border-yellow-700 pl-2 mb-2">
                                            <a href="{{ route('pages.show', $nav_page->slug) }}" class=" text-gray-500 text-sm">{{ $nav_page->title }}</a>
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>

    </x-actions-bar>

    <div class="w-full border-t-2 border-green-700 px-2 mb-4 lg:border-none lg:cols-span-3 lg:col-start-2 lg:col-end-5 lg:row-span-4 lg:mr-4 2xl:flex-grow 2xl:mr-0" id="main-box">
        <div class="bg-white shadow-2xl rounded p-3 md:w-11/12 md:mx-auto lg:pr-6 2xl:w-full">
            <div>
                <x-breadcrumb link="{{ route('sections.show', [$project->slug, $section->slug]) }}" name="{{ $section->title }}" project="{{ $project->name }}" route="{{ route('projects.show', $project->slug) }}"/>
                <p class="text-center mb-2 text-2xl md:text-3xl xl:font-bold xl:text-4xl xl:py-2">{{ $slug->title }}</p>
                <input type="hidden" name="section_id" value="{{ $slug->section_id }}">
                <div class="w-full mx-2 px-2">
                    @if(isset($content))
                        {!! $content !!}
                    @else
                        {!! $slug->content !!}
                    @endif
                </div>
            </div>
        </div>

        @if ($prev !== null || $next != null)
            <div class="bg-white shadow-2xl rounded p-3 mt-6 md:w-11/12 md:mx-auto 2xl:w-full">
                <div class="flex justify-between">
                    <div>
                        @if ($prev !== null)
                            <i class="bi bi-box-arrow-left float-left text-indigo-500"></i>
                            <a href="{{ route('pages.show', $prev->slug) }}" class="text-gray-500 hover:underline hover:text-gray-800 pl-2">{{ $prev->slug }}</a>
                        @endif
                    </div>
                    <div>
                        @if ($next !== null)
                            <a href="{{ route('pages.show', $next->slug) }}" class="float-left text-gray-500 hover:underline hover:text-gray-800 pr-2">{{ $next->slug }}</a>
                            <i class="bi bi-box-arrow-right text-indigo-500"></i>
                        @endif
                    </div>
                </div>
            </div>
        @endif

        @if ($displayComments === 'false')
            @include('partials.comments')
        @endif

    </div>

    <x-buttons :link="'pages'" :edit="'true'" :delete="'true'" id="{{ $slug->slug }}" new="{{ route('pages.create', [$section->project->slug, $section->slug]) }}" :page="'New'">

        <div class="p-2 ml-2 mr-1 w-1/3 lg:mx-auto lg:p-2 lg:w-10/12 lg:ml-0 lg:mb-2 2xl:w-8/12 2xl:mx-auto">
            <a href="{{ route('export.pdf', $slug->slug) }}" class="text-xs md:text-sm xl:text-base h-12">
                <i class="bi bi-plus-square icons"></i>
                Export PDF
            </a>
        </div>

        @if($revision !== null)
            <div class="p-2 ml-2 mr-1 w-1/3 lg:mx-auto lg:p-2 lg:w-10/12 lg:ml-0 lg:mb-2 2xl:w-8/12 2xl:mx-auto">
                <a href="{{ route('revisions.index', [$project->slug, $slug->id]) }}" class="text-xs md:text-sm xl:text-base h-12">
                    <i class="bi bi-plus-square icons"></i>
                    Revision
                </a>
            </div>
        @endif

        @include('partials.favorite')

    </x-buttons>

</x-app-layout>
