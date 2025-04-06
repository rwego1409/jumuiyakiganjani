@props([
    'name',
    'options' => [], // Default empty array
    'label' => null,
    'selected' => null
])

<div class="mb-4">
    @isset($label)
        <label for="{{ $name }}" class="block text-sm font-medium text-gray-700">
            {{ $label }}
        </label>
    @endisset

    <select 
        id="{{ $name }}" 
        name="{{ $name }}" 
        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
        {{ $attributes }}
    >
        @foreach ($options as $value => $label)
            <option value="{{ $value }}" {{ ($selected ?? old($name)) == $value ? 'selected' : '' }}>
                {{ $label }}
            </option>
        @endforeach
    </select>
</div>