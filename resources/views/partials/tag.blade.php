<div class="my-3">
    <div class="w-full py-2 border-2 border-gray-200">
        <button type="button" class="w-full text-left text-gray-500" id="btn-input-tag">
            <span><i class="bi bi-arrow-right-short"></i>Tags</span>
        </button>
    </div>

    <div class="hidden w-full py-4 px-2 border-2 border-gray-200 mt-2" id="area-tags">
        <input type="text" name="tags[]" class="w-full py-1 px-2 border-2 border-gray-200 mt-2 input-tag input-area-tags">
        {{-- <ul class="all-tags-created">
            @foreach ($allTags as $oneTag)
                <li>
                    <button type="button">{{ $oneTag->name }}</button>
                </li>
            @endforeach
        </ul> --}}
        <a href="javascript:void(0)" onclick="appendTag()" class="text-sm text-indigo-400 mt-4" id="add-input-tag">Add input tag</a>
    </div>
</div>
