@extends('layouts.chairperson')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
            {{ __('Resources Management') }}
        </h2>
        <a href="{{ route('chairperson.resources.create') }}" class="bg-primary-500 hover:bg-primary-600 text-white px-4 py-2 rounded-md">
            <i class="fas fa-plus mr-2"></i>{{ __('Add Resource') }}
        </a>
    </div>

    <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg overflow-hidden">
        @include('chairperson.resources.includes.filter')

        @if($resources->isEmpty())
            <div class="p-6 text-center text-gray-500 dark:text-gray-400">
                {{ __('No resources found') }}
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                {{ __('Name') }}
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                {{ __('Type') }}
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                {{ __('Description') }}
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                {{ __('Status') }}
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                {{ __('Actions') }}
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach($resources as $resource)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900 dark:text-white">
                                        {{ $resource->name }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-500 dark:text-gray-400">
                                        {{ ucfirst($resource->type) }}
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-500 dark:text-gray-400 truncate max-w-xs">
                                        {{ Str::limit($resource->description, 100) }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex px-2 text-xs font-semibold rounded-full
                                        @if($resource->status === 'active') bg-green-100 text-green-800
                                        @elseif($resource->status === 'inactive') bg-red-100 text-red-800
                                        @else bg-gray-100 text-gray-800 @endif">
                                        {{ ucfirst($resource->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                    <a href="{{ route('chairperson.resources.show', $resource->id) }}" 
                                       class="text-primary-600 hover:text-primary-900 dark:text-primary-500 dark:hover:text-primary-400">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('chairperson.resources.edit', $resource->id) }}"
                                       class="text-yellow-600 hover:text-yellow-900 dark:text-yellow-500 dark:hover:text-yellow-400">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('chairperson.resources.destroy', $resource->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="text-red-600 hover:text-red-900 dark:text-red-500 dark:hover:text-red-400"
                                                onclick="return confirm('{{ __('Are you sure you want to delete this resource?') }}')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="px-6 py-4">
                {{ $resources->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
