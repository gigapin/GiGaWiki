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
                            @foreach($rows as $row)
                                @if ($row->id === $activity->page_id)
                                    <a href="{{ route($url . '.show', $row->slug) }}">{{ $activity->details }}</a>
                                @endif
                            @endforeach
                            @if ($activity->type === 'deleted')
                                {{ $activity->details }}
                            @endif
                            {{ strtolower($activity->page_type) }}
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



