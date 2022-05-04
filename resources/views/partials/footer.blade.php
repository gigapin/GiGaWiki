<footer class="md:col-span-2">
    @if ($prev !== null || $next != null)
            <div class="bg-white shadow-2xl rounded p-3 mt-6 md:mx-auto 2xl:w-full">
                <div class="flex justify-between">
                    <div>
                        @if ($prev !== null)
                            <i class="bi bi-box-arrow-left float-left text-indigo-500"></i>
                            <a href="{{ route('document.show', [$project->slug, $doc->section->slug, $prev->slug]) }}" class="text-gray-500 hover:underline hover:text-gray-800 pl-2">{{ $prev->slug }}</a>
                        @endif
                    </div>
                    <div>
                        @if ($next !== null)
                            <a href="{{ route('document.show', [$project->slug, $doc->section->slug, $next->slug]) }}" class="float-left text-gray-500 hover:underline hover:text-gray-800 pr-2">{{ $next->slug }}</a>
                            <i class="bi bi-box-arrow-right text-indigo-500"></i>
                        @endif
                    </div>
                </div>
            </div>
        @endif
</footer>