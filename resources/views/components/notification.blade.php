@props(['type' => 'success', 'message' => ''])

@php
    $colors = [
        'success' => 'bg-green-100 border-green-400 text-green-700',
        'error' => 'bg-red-100 border-red-400 text-red-700',
        'warning' => 'bg-yellow-100 border-yellow-400 text-yellow-700',
        'info' => 'bg-blue-100 border-blue-400 text-blue-700',
    ];
    
    $icons = [
        'success' => 'check-circle',
        'error' => 'exclamation-circle',
        'warning' => 'exclamation',
        'info' => 'information-circle',
    ];
@endphp

<div x-data="{ show: true }" x-show="show" x-transition:leave="transition ease-in duration-300" 
     x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
     class="{{ $colors[$type] }} border px-4 py-3 rounded relative mb-4" role="alert">
    <div class="flex items-center">
        <div class="py-1">
            <x-icon name="{{ $icons[$type] }}" class="h-6 w-6 mr-2" />
        </div>
        <div>
            <span class="block sm:inline">{{ $message }}</span>
        </div>
        <span class="absolute top-0 bottom-0 right-0 px-4 py-3" @click="show = false">
            <x-icon name="x" class="h-6 w-6" />
        </span>
    </div>
</div>