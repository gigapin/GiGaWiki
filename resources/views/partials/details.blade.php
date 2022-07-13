<div class="w-full text-left mt-0">
    <p class="font-semibold text-xl mt-0">Details</p>
    <div class="mb-4">
        <i class="bi bi-plus-square mini-icons float-left mr-2"></i>
        <p class="text-gray-700 text-sm">Created {{ Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $slug->created_at)->diffForHumans() }} by {{ $user->name }}</p>
    </div>

    @if($slug->created_at != $slug->updated_at)
        <div class="my-4">
            <i class="bi bi-pencil-square mini-icons float-left mr-2"></i>
            <p class="text-gray-700 text-sm">Updated {{ Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $slug->updated_at)->diffForHumans() }} by {{ $user->name }}</p>
        </div>
    @endif
</div>
