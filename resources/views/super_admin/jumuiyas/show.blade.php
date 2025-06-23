@extends('layouts.super_admin')

@section('content')
<div class="max-w-7xl mx-auto px-2 sm:px-4 md:px-6 lg:px-8 py-4 sm:py-8">
    <div class="mb-4 sm:mb-6 flex flex-col sm:flex-row sm:justify-between sm:items-center gap-2 sm:gap-0">
        <h2 class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-white truncate">
            {{ $jumuiya->name }}
        </h2>
        <div class="flex flex-col sm:flex-row gap-2 sm:space-x-3 w-full sm:w-auto">
            <a href="{{ route('super_admin.jumuiyas.edit', $jumuiya) }}" 
               class="inline-flex items-center justify-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 w-full sm:w-auto">
                <i class="fas fa-edit mr-2"></i>{{ __('Edit') }}
            </a>
            <form action="{{ route('super_admin.jumuiyas.destroy', $jumuiya) }}" method="POST" class="inline w-full sm:w-auto">
                @csrf
                @method('DELETE')
                <button type="submit" 
                        onclick="return confirm('Are you sure you want to delete this jumuiya?')"
                        class="inline-flex items-center justify-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:bg-red-700 active:bg-red-900 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150 w-full sm:w-auto">
                    <i class="fas fa-trash mr-2"></i>{{ __('Delete') }}
                </button>
            </form>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 md:gap-6">
        <!-- Main Information -->
        <div class="col-span-1 md:col-span-2">
            <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg overflow-hidden mb-4 md:mb-0">
                <div class="p-4 sm:p-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2 sm:mb-4">
                        {{ __('Jumuiya Information') }}
                    </h3>
                    <dl class="grid grid-cols-1 sm:grid-cols-2 gap-2 sm:gap-4">
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Location') }}</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-white break-words">{{ $jumuiya->location }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Status') }}</dt>
                            <dd class="mt-1">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $jumuiya->status === 'active' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300' : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300' }}">
                                    {{ ucfirst($jumuiya->status) }}
                                </span>
                            </dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Meeting Schedule') }}</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-white">
                                @if($jumuiya->meeting_day && $jumuiya->meeting_time)
                                    {{ ucfirst($jumuiya->meeting_day) }}s at {{ \Carbon\Carbon::parse($jumuiya->meeting_time)->format('h:i A') }}
                                @else
                                    {{ __('Not scheduled') }}
                                @endif
                            </dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Created') }}</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-white">
                                {{ $jumuiya->created_at->format('M d, Y') }}
                            </dd>
                        </div>
                    </dl>

                    @if($jumuiya->description)
                        <div class="mt-4 sm:mt-6">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Description') }}</dt>
                            <dd class="mt-2 text-sm text-gray-900 dark:text-white whitespace-pre-line break-words">{{ $jumuiya->description }}</dd>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Members List -->
            <div class="mt-4 md:mt-6 bg-white dark:bg-gray-800 shadow-sm rounded-lg overflow-x-auto">
                <div class="p-4 sm:p-6">
                    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center mb-2 sm:mb-4 gap-2 sm:gap-0">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white">
                            {{ __('Members') }}
                        </h3>
                        <button type="button" 
                                onclick="window.location.href='{{ route('super_admin.members.create', ['jumuiya' => $jumuiya->id]) }}'"
                                class="inline-flex items-center px-3 py-1.5 bg-indigo-600 border border-transparent rounded-md text-xs text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 w-full sm:w-auto">
                            <i class="fas fa-plus mr-2"></i>{{ __('Add Member') }}
                        </button>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 text-xs sm:text-sm">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th scope="col" class="px-2 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider whitespace-nowrap">
                                        {{ __('Name') }}
                                    </th>
                                    <th scope="col" class="px-2 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider whitespace-nowrap">
                                        {{ __('Contact') }}
                                    </th>
                                    <th scope="col" class="px-2 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider whitespace-nowrap">
                                        {{ __('Status') }}
                                    </th>
                                    <th scope="col" class="px-2 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider whitespace-nowrap">
                                        {{ __('Joined') }}
                                    </th>
                                    <th scope="col" class="px-2 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider whitespace-nowrap">
                                        {{ __('Role') }}
                                    </th>
                                    <th scope="col" class="px-2 sm:px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider whitespace-nowrap">
                                        {{ __('Actions') }}
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse($members as $member)
                                    <tr>
                                        <td class="px-2 sm:px-6 py-4 whitespace-nowrap max-w-[120px] sm:max-w-none">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-8 w-8 sm:h-10 sm:w-10">
                                                    <img class="h-8 w-8 sm:h-10 sm:w-10 rounded-full object-cover" src="{{ $member->user->profile_photo_url }}" alt="{{ $member->name }}">
                                                </div>
                                                <div class="ml-2 sm:ml-4">
                                                    <div class="text-xs sm:text-sm font-medium text-gray-900 dark:text-white truncate">
                                                        {{ $member->name }}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-2 sm:px-6 py-4 whitespace-nowrap">
                                            <div class="text-xs sm:text-sm text-gray-900 dark:text-white break-words">{{ $member->user->email }}</div>
                                            <div class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 break-words">{{ $member->user->phone }}</div>
                                        </td>
                                        <td class="px-2 sm:px-6 py-4 whitespace-nowrap">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $member->status === 'active' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300' : 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300' }}">
                                                {{ ucfirst($member->status) }}
                                            </span>
                                        </td>
                                        <td class="px-2 sm:px-6 py-4 whitespace-nowrap text-xs sm:text-sm text-gray-500 dark:text-gray-400">
                                            {{ $member->created_at->format('M d, Y') }}
                                        </td>
                                        <td class="px-2 sm:px-6 py-4 whitespace-nowrap">
                                            <form method="POST" action="{{ route('super_admin.members.updateRole', $member) }}">
                                                @csrf
                                                @method('PATCH')
                                                <select name="role" class="form-input w-full text-xs sm:text-sm" onchange="this.form.submit()">
                                                    <option value="member" {{ $member->role === 'member' ? 'selected' : '' }}>Member</option>
                                                    <option value="chairperson" {{ $member->role === 'chairperson' ? 'selected' : '' }}>Chairperson</option>
                                                    <option value="admin" {{ $member->role === 'admin' ? 'selected' : '' }}>Admin</option>
                                                </select>
                                            </form>
                                        </td>
                                        <td class="px-2 sm:px-6 py-4 whitespace-nowrap text-right text-xs sm:text-sm font-medium">
                                            <a href="{{ route('super_admin.members.show', $member) }}" 
                                               class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-900 dark:hover:text-indigo-300 mr-2 sm:mr-3">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('super_admin.members.edit', $member) }}" 
                                               class="text-blue-600 dark:text-blue-400 hover:text-blue-900 dark:hover:text-blue-300">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-2 sm:px-6 py-4 whitespace-nowrap text-xs sm:text-sm text-gray-500 dark:text-gray-400 text-center">
                                            {{ __('No members found.') }}
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if($members->hasPages())
                        <div class="px-2 sm:px-6 py-4 border-t border-gray-200 dark:border-gray-700">
                            {{ $members->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Sidebar Information -->
        <div class="space-y-4 md:space-y-6 mt-4 md:mt-0">
            <!-- Chairperson Card -->
            <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg overflow-hidden">
                <div class="p-4 sm:p-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2 sm:mb-4">
                        {{ __('Chairperson') }}
                    </h3>
                    @if($jumuiya->chairperson)
                        <div class="flex flex-col sm:flex-row items-center gap-2 sm:gap-4">
                            <div class="flex-shrink-0">
                                <img class="h-10 w-10 sm:h-12 sm:w-12 rounded-full object-cover" 
                                     src="{{ $jumuiya->chairperson->profile_photo_url }}" 
                                     alt="{{ $jumuiya->chairperson->name }}">
                            </div>
                            <div class="text-center sm:text-left">
                                <h4 class="text-xs sm:text-sm font-medium text-gray-900 dark:text-white">
                                    {{ $jumuiya->chairperson->name }}
                                </h4>
                                <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400">
                                    {{ $jumuiya->chairperson->email }}
                                </p>
                                <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400">
                                    {{ $jumuiya->chairperson->phone }}
                                </p>
                            </div>
                        </div>
                    @else
                        <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400">{{ __('No chairperson assigned.') }}</p>
                    @endif
                </div>
            </div>

            <!-- Statistics Card -->
            <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg overflow-hidden">
                <div class="p-4 sm:p-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2 sm:mb-4">
                        {{ __('Statistics') }}
                    </h3>
                    <dl class="space-y-2 sm:space-y-4">
                        <div>
                            <dt class="text-xs sm:text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Total Members') }}</dt>
                            <dd class="mt-1 text-2xl sm:text-3xl font-semibold text-gray-900 dark:text-white">{{ $memberCount }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs sm:text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Active Members') }}</dt>
                            <dd class="mt-1 text-2xl sm:text-3xl font-semibold text-green-600 dark:text-green-400">{{ $activeMembers }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs sm:text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Pending Members') }}</dt>
                            <dd class="mt-1 text-2xl sm:text-3xl font-semibold text-yellow-600 dark:text-yellow-400">{{ $pendingMembers }}</dd>
                        </div>
                    </dl>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
