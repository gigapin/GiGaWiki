@if(count($tags) > 0)
    <div class="my-4">
        <p class="font-semibold text-xl mt-0">Tags</p>
        <ul class="list-none m-0 p-0">
            @foreach($tags as $tag)
                <li>
                    <i class="bi bi-tag mini-icons"></i>
                    {{ $tag->name }}
                </li>
            @endforeach
        </ul>
    </div>
@endif
