
<div class="my-3">
    <div class="w-full py-2 border-2 border-gray-200">
        <button type="button" class="w-full text-left text-gray-500" id="btn-input-file">
            <span><i class="bi bi-arrow-right-short"></i>Upload Image</span>
        </button>
    </div>


    <div class="hidden w-full py-4 px-2 border-2 border-gray-200 mt-2" id="input-file">
        @error($name)
        <p class="text-red-500 text-sm">{{ $message }}</p>
        @enderror
        <label class="
            flex flex-col
            items-center
            px-2
            py-2
            bg-white
            rounded-md
            shadow-md
            tracking-wide
            border border-blue
            cursor-pointer
            hover:bg-green-600 hover:text-white
            text-green-600
            ease-linear
            transition-all
            duration-150
            md:w-1/3
            "
        >
            <i class="bi bi-cloud-arrow-up-fill"></i>
            <span class="mt-2 text-base leading-normal">{{ $label }}</span>
            <input type="file" name="{{ $name }}" class="hidden" />
        </label>
    </div>
</div>
