<div class="py-2 mb-3">
    <textarea id="note" name="{{ $name }}" class="w-full rounded-md h-96 lg:h-72 xl:h-96 text-gray-700">
        @isset($content)
            {!! $content !!}
        @endisset
    </textarea>
</div>
@error($name)
<div class="mt-3">
    <p class="text-red-500 text-sm">{{ $message }}</p>
</div>
@enderror
