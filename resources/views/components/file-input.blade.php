<div class="mb-4">
    <!-- Ensure 'label' is passed to the component -->
    <label for="{{ $id }}" class="block text-sm font-medium text-gray-700">{{ $label ?? 'Upload File' }}</label>
    <input type="file" id="{{ $id }}" name="{{ $name }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" {{ $attributes }} />
</div>

