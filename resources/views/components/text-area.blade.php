<div class="mb-4">
    @isset($label)
        <label for="{{ $name }}" class="block text-sm font-medium text-gray-700">{{ $label }}</label>
    @endisset

    <textarea id="{{ $name }}" name="{{ $name }}" rows="4" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>{{ $value ?? old($name) }}</textarea>
</div>
