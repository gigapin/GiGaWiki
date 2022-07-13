@if(count($views) > 0)
    <div class="w-full text-left">
        <p class="font-semibold text-xl mt-0">More Visited</p>
        <ul class="list-none text-sm ml-0 pl-0 mt-0">
            @foreach($views as $view)
                <li class="mb-4">
                    <div class="float-left">
                        <i class="bi bi-file-earmark-text icons"></i>
                    </div>
                    <div class="ml-4 pl-4 mb-2">
                        @foreach($rows as $row)
                            @if ($row->id === $view->page_id)
                                <a href="{{ route($view->page_type . 's.show', $row->slug) }}">{{ $row->$name }}</a>
                            @endif
                        @endforeach
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
@endif
