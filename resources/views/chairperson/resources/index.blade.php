@extends('layouts.chairperson')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-pink-50 via-white to-purple-100 dark:from-pink-900 dark:via-gray-800 dark:to-purple-900 py-8 sm:py-12">
    <div class="max-w-6xl mx-auto px-2 sm:px-4 lg:px-8">
        <div class="bg-white/80 dark:bg-purple-900/80 backdrop-blur-md shadow-2xl rounded-2xl border border-pink-200/60 dark:border-purple-700/60 p-4 sm:p-8">
            <div class="mb-6 flex flex-col sm:flex-row items-center gap-2 sm:gap-3 justify-between">
                <h2 class="text-xl sm:text-2xl font-bold bg-gradient-to-r from-pink-600 to-purple-600 bg-clip-text text-transparent drop-shadow-lg text-center sm:text-left w-full">
                    <svg class="w-8 h-8 text-pink-500 dark:text-pink-300 inline-block mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 17v-2a4 4 0 014-4h2a4 4 0 014 4v2M9 17H7a4 4 0 01-4-4V7a4 4 0 014-4h10a4 4 0 014 4v6a4 4 0 01-4 4h-2M9 17v2a4 4 0 004 4h2a4 4 0 004-4v-2"/>
                    </svg>
                    {{ __('Resources Management') }}
                </h2>
                <a href="{{ route('chairperson.resources.create') }}" class="mt-2 sm:mt-0 inline-flex items-center px-4 py-2 bg-yellow-100 text-yellow-700 border border-yellow-200 rounded-xl font-semibold text-xs sm:text-sm uppercase tracking-widest shadow hover:bg-yellow-200 hover:text-yellow-900 focus:outline-none focus:ring-2 focus:ring-yellow-400 transition">
                    <i class="fas fa-plus mr-2 text-yellow-500"></i> {{ __('Add Resource') }}
                </a>
            </div>

            <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg overflow-hidden">
                @include('chairperson.resources.includes.filter')

                @if($resources->isEmpty())
                    <div class="p-6 text-center text-gray-500 dark:text-gray-400">
                        {{ __('No resources found') }}
                    </div>
                @else
                    <div class="overflow-x-auto rounded-lg">
                        <table class="min-w-full divide-y divide-pink-200 dark:divide-purple-700">
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
                                                <i class="fas fa-eye text-yellow-500"></i>
                                            </a>
                                            <a href="{{ route('chairperson.resources.edit', $resource->id) }}"
                                               class="bg-yellow-100 text-yellow-700 hover:bg-yellow-200 hover:text-yellow-900 px-3 py-1 rounded font-semibold shadow focus:outline-none focus:ring-2 focus:ring-yellow-400 transition mr-2">
                                                <i class="fas fa-edit text-yellow-500"></i>
                                            </a>
                                            <form action="{{ route('chairperson.resources.destroy', $resource->id) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="bg-yellow-100 text-yellow-700 hover:bg-yellow-200 hover:text-yellow-900 px-3 py-1 rounded font-semibold shadow focus:outline-none focus:ring-2 focus:ring-yellow-400 transition">
                                                    <i class="fas fa-trash text-yellow-500"></i>
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
    </div>
</div>
@endsection
