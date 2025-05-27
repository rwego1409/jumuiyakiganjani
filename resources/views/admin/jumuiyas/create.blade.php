@extends('layouts.admin')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg">
            <div class="p-6">
                <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-200 mb-6">
                    Create New Jumuiya
                </h2>

                <form action="{{ route('admin.jumuiyas.store') }}" method="POST">
                    @csrf
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Name -->
                        <div>
                            <x-input-label for="name" :value="__('Jumuiya Name')" />
                            <x-text-input id="name" 
                                         name="name" 
                                         type="text" 
                                         :value="old('name')" 
                                         class="mt-1 block w-full" 
                                         required 
                                         autofocus />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <!-- Location -->
                        <div>
                            <x-input-label for="location" :value="__('Location')" />
                            <x-text-input id="location" 
                                         name="location" 
                                         type="text" 
                                         :value="old('location')" 
                                         class="mt-1 block w-full" 
                                         required />
                            <x-input-error :messages="$errors->get('location')" class="mt-2" />
                        </div>

                        <!-- Chairperson -->
                        <div class="md:col-span-2">
                            <x-input-label for="chairperson_id" :value="__('Chairperson')" />
                            <select id="chairperson_id" 
                                    name="chairperson_id" 
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm"
                                    required>
                                <option value="">Select a Chairperson</option>
                                @foreach($chairpersons as $chairperson)
                                    <option value="{{ $chairperson->id }}" {{ old('chairperson_id') == $chairperson->id ? 'selected' : '' }}>
                                        {{ $chairperson->name }} ({{ $chairperson->email }})
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('chairperson_id')" class="mt-2" />
                        </div>

                        <!-- Description -->
                        <div class="md:col-span-2">
                            <x-input-label for="description" :value="__('Description')" />
                            <textarea id="description" 
                                     name="description" 
                                     rows="4"
                                     class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm">{{ old('description') }}</textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>
                    </div>

                    <div class="flex items-center justify-end mt-6">
                        <a href="{{ route('admin.jumuiyas.index') }}" 
                           class="text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 mr-4">
                            Cancel
                        </a>
                        <x-primary-button>
                            Create Jumuiya
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
