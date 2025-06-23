@extends('layouts.admin')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-blue-100 dark:from-blue-900 dark:via-gray-800 dark:to-blue-900 py-12">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-md shadow-2xl rounded-2xl border border-blue-200/50 dark:border-blue-900/50 p-8">
            <div class="flex items-center justify-between mb-8">
                <h2 class="text-3xl font-bold text-blue-700 dark:text-blue-300 flex items-center gap-2 md:text-4xl lg:text-5xl">
                    <svg class="w-8 h-8 text-blue-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87m13-6.13V7a4 4 0 00-3-3.87M6 4.13A4 4 0 019 4h6a4 4 0 013 3.87v2.13M12 14v6m0 0a2 2 0 01-2-2h4a2 2 0 01-2 2z"/></svg>
                    Member Details
                </h2>
                <div class="space-x-4">
                    <a href="{{ route('admin.members.edit', $member->id) }}" class="inline-flex items-center px-4 py-2 rounded-xl shadow font-semibold text-white bg-gradient-to-r from-blue-600 to-blue-500 hover:from-blue-700 hover:to-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all">
                        Edit Member
                    </a>
                    <a href="{{ route('admin.members.index') }}" class="inline-flex items-center px-4 py-2 rounded-xl shadow font-semibold text-blue-700 dark:text-blue-300 bg-blue-100 dark:bg-blue-900/30 hover:bg-blue-200 dark:hover:bg-blue-900/50 transition-all">
                        Back to List
                    </a>
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Personal Information -->
                <div class="bg-white/70 dark:bg-gray-700/70 rounded-xl shadow p-6 border border-blue-100 dark:border-blue-900/30">
                    <h3 class="text-lg font-semibold text-blue-700 dark:text-blue-300 mb-4 flex items-center gap-2">
                        <svg class="w-6 h-6 text-blue-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5.121 17.804A13.937 13.937 0 0112 15c2.5 0 4.847.655 6.879 1.804M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        Personal Information
                    </h3>
                    <dl class="space-y-4">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Full Name</dt>
                            <dd class="mt-1 text-gray-900 dark:text-gray-100 font-semibold">{{ $member->user->name }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Email</dt>
                            <dd class="mt-1 text-gray-900 dark:text-gray-100 font-semibold">{{ $member->user->email }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Phone</dt>
                            <dd class="mt-1 text-gray-900 dark:text-gray-100 font-semibold">{{ $member->phone }}</dd>
                        </div>
                    </dl>
                </div>
                <!-- Membership Details -->
                <div class="bg-white/70 dark:bg-gray-700/70 rounded-xl shadow p-6 border border-blue-100 dark:border-blue-900/30">
                    <h3 class="text-lg font-semibold text-blue-700 dark:text-blue-300 mb-4 flex items-center gap-2">
                        <svg class="w-6 h-6 text-blue-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 01.88 7.903A5 5 0 0112 20a5 5 0 01-4.88-5.097A4 4 0 018 7m8 0a4 4 0 00-8 0"/></svg>
                        Membership Details
                    </h3>
                    <dl class="space-y-4">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Jumuiya</dt>
                            <dd class="mt-1 text-gray-900 dark:text-gray-100 font-semibold">{{ $member->jumuiya->name }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Status</dt>
                            <dd class="mt-1">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    {{ $member->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ ucfirst($member->status) }}
                                </span>
                            </dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Joined Date</dt>
                            <dd class="mt-1 text-gray-900 dark:text-gray-100 font-semibold">{{ $member->joined_date->format('M d, Y') }}</dd>
                        </div>
                    </dl>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection