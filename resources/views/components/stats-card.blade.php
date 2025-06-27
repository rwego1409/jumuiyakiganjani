@props(['title', 'value', 'icon', 'color' => 'indigo'])

<div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100">
    <div class="flex items-center">
        <div class="flex-shrink-0 bg-{{ $color }}-100 p-3 rounded-lg">
            {{-- <x-icon name="{{ $icon }}" class="h-6 w-6 text-{{ $color }}-600" /> --}}
        </div>
        <div class="ml-4">
            <dt class="text-sm font-medium text-gray-500 truncate">
                {{ $title }}
            </dt>
            <dd class="mt-1 text-3xl font-semibold text-gray-900">
                {{ $value }}
            </dd>
        </div>
    </div>
</div>