
<div class="relative flex w-full flex-wrap items-stretch mb-3 mt-6">
    <input
        type="text"
        placeholder="{{ $label }}"
        name="{{ $name }}"
        class="
          px-3
          py-4
          placeholder-gray-400
          text-gray-800
          relative
          bg-white 
          rounded
          text-xl
          font-extrabold
          border border-gray-400
          outline-none
          focus:outline-none focus:ring
          w-full
            "
        @isset ($value)
            value='{{ $value }}'
        @else
            value="{{ old($name) }}"
        @endisset
    />
</div>
<div class="mt-3">
    @error($name)
        <p class="text-red-500 text-sm">{{ $message }}</p>
    @enderror
</div>
