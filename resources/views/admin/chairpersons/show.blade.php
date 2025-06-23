@extends('layouts.admin')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-blue-100 dark:from-blue-900 dark:via-gray-800 dark:to-blue-900 py-12">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-md shadow-2xl rounded-2xl border border-blue-200/50 dark:border-blue-900/50 p-8">
            <div class="flex items-center justify-between mb-8">
                <h2 class="text-3xl font-bold text-blue-700 dark:text-blue-300">Chairperson Details</h2>
                <div class="space-x-4">
                    <a href="{{ route('admin.chairpersons.edit', $chairperson->id) }}" class="inline-flex items-center px-4 py-2 rounded-xl shadow font-semibold text-white bg-gradient-to-r from-blue-600 to-blue-500 hover:from-blue-700 hover:to-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all">
                        Edit Chairperson
                    </a>
                    <a href="{{ route('admin.chairpersons.index') }}" class="inline-flex items-center px-4 py-2 rounded-xl shadow font-semibold text-blue-700 dark:text-blue-300 bg-blue-100 dark:bg-blue-900/30 hover:bg-blue-200 dark:hover:bg-blue-900/50 transition-all">
                        Back to List
                    </a>
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Personal Information -->
                <div class="bg-white/70 dark:bg-gray-700/70 rounded-xl shadow p-6 border border-blue-100 dark:border-blue-900/30">
                    <h3 class="text-lg font-semibold text-blue-700 dark:text-blue-300 mb-4">Personal Information</h3>
                    <dl class="space-y-4">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Full Name</dt>
                            <dd class="mt-1 text-gray-900 dark:text-gray-100 font-semibold">{{ $chairperson->user?->name ?? '-' }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Email</dt>
                            <dd class="mt-1 text-gray-900 dark:text-gray-100 font-semibold">{{ $chairperson->user?->email ?? '-' }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Phone</dt>
                            <dd class="mt-1 text-gray-900 dark:text-gray-100 font-semibold">{{ $chairperson->phone ?? '-' }}</dd>
                        </div>
                    </dl>
                </div>
                <!-- Jumuiya Details -->
                <div class="bg-white/70 dark:bg-gray-700/70 rounded-xl shadow p-6 border border-blue-100 dark:border-blue-900/30">
                    <h3 class="text-lg font-semibold text-blue-700 dark:text-blue-300 mb-4">Jumuiya</h3>
                    <dl class="space-y-4">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Jumuiya</dt>
                            <dd class="mt-1 text-gray-900 dark:text-gray-100 font-semibold">{{ $chairperson->jumuiya->name ?? '-' }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Location</dt>
                            <dd class="mt-1 text-gray-900 dark:text-gray-100 font-semibold">{{ $chairperson->jumuiya->location ?? '-' }}</dd>
                        </div>
                    </dl>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
