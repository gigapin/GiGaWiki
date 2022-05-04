<sidebar class="hidden w-10/12 md:w-full md:row-span-3 bg-gray-300 md:block  max-h-screen p-4 " id="menux">
    {{-- md:row-span-3 --}}
    <a href="{{ route('document', $project->slug) }}" class="text-xl md:text-2xl font-extrabold text-gray-800">{{ $project->name }}</a>
    <ul class="list-none">
        @foreach($sections as $section)
            <li>
                <div class="bg-gray-200 py-1 px-2 mb-0">
                    @if($section->description !==null)
                        <a href="{{ route('document.section', [$project->slug, $section->slug]) }}" class="text-lg md:text-xl font-bold text-gray-700 cursor-pointer">{{ $section->title }}</a>
                    @else
                        <p class="text-lg md:text-xl font-bold text-gray-700">{{ $section->title }}</p>
                    @endif 
                </div>
                <ul class="list-none mt-0">
                    @foreach($pages as $page)
                        @if($page->section_id === $section->id)
                            <li class="border-b border-gray-400 mt-1 p-1">
                                <a class="text-sm text-gray-800" href="{{ route('document.show', [$project->slug, $section->slug, $page->slug]) }}">{{ $page->title }}</a>    
                            </li>
                        @endif
                    @endforeach
                </ul>
            </li>
        @endforeach
    </ul>
</sidebar>