@extends('layouts.chairperson')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 to-blue-50 dark:from-slate-900 dark:to-slate-800 transition-colors duration-300 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-slate-800 rounded-xl border border-slate-200 dark:border-slate-700 shadow-lg overflow-hidden">
            <div class="p-6 border-b border-slate-200 dark:border-slate-700 flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <a href="{{ route('chairperson.dashboard') }}" class="inline-flex items-center px-4 py-2 btn-indigo rounded-lg shadow transition-all duration-200 hover:shadow-md focus:outline-none focus:ring-2 focus:ring-indigo-400">
                        <svg class="w-5 h-5 mr-2 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                        Back to Dashboard
                    </a>
                    <h2 class="text-2xl font-bold text-slate-800 dark:text-white flex items-center ml-2">
                        <svg class="w-7 h-7 mr-2 text-indigo-500 dark:text-indigo-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        System Activity Log
                    </h2>
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200 dark:divide-slate-700">
                    <thead class="bg-slate-50 dark:bg-slate-900">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider">User</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Action</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Description</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Date</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-slate-800 divide-y divide-slate-200 dark:divide-slate-700">
                        @forelse($activities as $activity)
                        <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/50 transition-colors duration-200">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="font-bold text-slate-800 dark:text-white">{{ $activity->user->name ?? 'System' }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-semibold bg-{{ $activity->getActionColor() }}-100 text-{{ $activity->getActionColor() }}-800 dark:bg-{{ $activity->getActionColor() }}-900/30 dark:text-{{ $activity->getActionColor() }}-200">
                                    <i class="fas fa-{{ $activity->getActivityIcon() }} mr-1"></i> {{ ucfirst($activity->action) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-slate-700 dark:text-slate-300">
                                {{ $activity->description }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-xs text-slate-500 dark:text-slate-400">
                                {{ $activity->created_at->format('M d, Y h:i A') }}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-6 py-8 text-center text-slate-400 dark:text-slate-500">
                                No activity found for your jumuiya.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="p-6 border-t border-slate-200 dark:border-slate-700">
                {{ $activities->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
