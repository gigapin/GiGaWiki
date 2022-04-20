<label class="block text-left mb-3">
    <span class="text-gray-600">{{ $label }}</span>
    <select class="form-select block w-full mt-1 rounded-sm border-gray-400 @error($name) border-4 border-red-600 @enderror" name="{{ $name }}">
        <option value=""></option>
        {{ $slot }}
    </select>
</label>
@error($name)
<p class="text-red-500 text-sm">{{ $message }}</p>
@enderror
