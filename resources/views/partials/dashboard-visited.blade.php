@if(count($activities) > 0)
    <div class="w-full text-left">
        <p class="font-semibold text-xl mt-0">Recent Activity</p>
        <ul class="list-none text-sm ml-0 pl-0 mt-0">
            @foreach($activities as $activity)
                <li class="mb-4">
                    <div class="float-left">
                        <i class="bi bi-person-workspace icons"></i>
                    </div>
                    <div class="ml-4 pl-4 mb-2">
                        <span class="leading-3">
                            {{ $user->name }} {{ $activity->type }}
                            @if($activity->page_type !== 'section')
                                @foreach($rows as $row)
                                    @if ($row->id === $activity->page_id)
                                        <a href="{{ route($activity->page_type . 's.show', $row->slug) }}">{{ $row->$name }}</a>
                                    @endif
                                @endforeach
                                @if ($activity->details !== null)
                                    {{ $activity->details }}
                                @endif
                                {{ strtolower($activity->page_type) }}
                            @endif
                        </span>
                    </div>
                    <div class="ml-4 pl-4">
                        <span class="text-xs">
                            <i class="bi bi-clock mini-icons"></i>
                            {{ $activity->updated_at }}
                        </span>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
@endif

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
                        @foreach($url as $row)
                            @if($view->page_id == $row->id)
                                <a href="{{ route($view->page_type . 's.show', $row->slug) }}">{{ $row->$name }}</a>
                            @endif
                        @endforeach
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
@endif
