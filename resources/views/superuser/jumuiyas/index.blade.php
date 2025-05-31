@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
            {{ __('Jumuiya Management') }}
        </h2>
        <a href="{{ route('superuser.jumuiyas.create') }}" class="bg-primary-500 hover:bg-primary-600 text-white px-4 py-2 rounded-md">
            <i class="fas fa-plus mr-2"></i>{{ __('Create Jumuiya') }}
        </a>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($jumuiyas as $jumuiya)
        <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg overflow-hidden flex flex-col justify-between">
            <div class="p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">{{ $jumuiya->name }}</h3>
                <p class="text-gray-600 dark:text-gray-400 mb-4">{{ Str::limit($jumuiya->description, 100) }}</p>
                <a href="{{ route('superuser.jumuiyas.show', $jumuiya) }}" class="bg-primary-500 hover:bg-primary-600 text-white px-4 py-2 rounded-md">
                    {{ __('Manage') }}
                </a>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
