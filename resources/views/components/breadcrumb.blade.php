<div class="border-b-2 border-green-600 mt-0">
    <ul class="list-none mx-0 px-0 py-4 md:py-2">
        <li class="hidden md:mr-1 md:inline-block">
            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-file-earmark text-indigo-300" viewBox="0 0 16 16">
                <path d="M14 4.5V14a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2h5.5L14 4.5zm-3 0A1.5 1.5 0 0 1 9.5 3V1H4a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V4.5h-2z"/>
            </svg>
        </li>
        @if($root !== null)
            <li class="hidden md:mr-2 md:inline-block md:align-top">
                <a class="hover:text-gray-600  text-sm hover:no-underline text-yellow-600" href="{{ route( $root . '.index') }}">
                    {{ ucfirst($root) }}
                </a>
            </li>
        @else
            <li class="hidden md:mr-2 md:inline-block md:align-top">
                <a class="hover:text-gray-600  text-sm hover:no-underline text-yellow-600" href="{{ route('projects.index') }}">
                    Projects
                </a>
            </li>
        @endif
        @if($route !== null)
            <li class="hidden md:mr-2 md:inline-block">
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-arrow-right-circle text-indigo-300" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M1 8a7 7 0 1 0 14 0A7 7 0 0 0 1 8zm15 0A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM4.5 7.5a.5.5 0 0 0 0 1h5.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H4.5z"/>
                </svg>
            </li>
            <li class="hidden md:mr-2 md:inline-block md:align-top">
                <a class="hover:text-gray-600 hover:no-underline text-yellow-600 text-sm" href="{{ $route }}">
                    {{ $project }}
                </a>
            </li>
        @endif
        <li class="hidden md:mr-2 md:inline-block">
            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-arrow-right-circle text-indigo-300" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M1 8a7 7 0 1 0 14 0A7 7 0 0 0 1 8zm15 0A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM4.5 7.5a.5.5 0 0 0 0 1h5.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H4.5z"/>
            </svg>
        </li>
        <li class="hidden md:mr-2 md:inline-block md:align-top">
            <a class="hover:text-gray-600  text-sm hover:no-underline text-yellow-600" href="{{ $link }}">
                {{ $name }}
            </a>
        </li>
        @if($value !== null)
            <li class="float-right">
                <button type="submit" class="text-sm px-2 py-1 bg-green-400 text-white ring-2 ring-green-500 rounded-sm hover:shadow-xl hover:bg-green-300 lg:py-2 px-4">{{ $value }}</button>
            </li>
        @endif
    </ul>
</div>
