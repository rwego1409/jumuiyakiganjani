@extends('layouts.admin')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-blue-100 dark:from-blue-900 dark:via-gray-800 dark:to-blue-900 py-12">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-md shadow-2xl rounded-2xl border border-blue-200/50 dark:border-blue-900/50 p-8">
            <div class="flex items-center justify-between mb-8">
                <h2 class="text-3xl font-bold text-blue-700 dark:text-blue-300">Jumuiya Details</h2>
                <div class="space-x-4">
                    <a href="{{ route('admin.jumuiyas.edit', $jumuiya->id) }}" class="inline-flex items-center px-4 py-2 rounded-xl shadow font-semibold text-white bg-gradient-to-r from-blue-600 to-blue-500 hover:from-blue-700 hover:to-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all">
                        Edit Jumuiya
                    </a>
                    <a href="{{ route('admin.jumuiyas.index') }}" class="inline-flex items-center px-4 py-2 rounded-xl shadow font-semibold text-blue-700 dark:text-blue-300 bg-blue-100 dark:bg-blue-900/30 hover:bg-blue-200 dark:hover:bg-blue-900/50 transition-all">
                        Back to List
                    </a>
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Jumuiya Information -->
                <div class="bg-white/70 dark:bg-gray-700/70 rounded-xl shadow p-6 border border-blue-100 dark:border-blue-900/30">
                    <h3 class="text-lg font-semibold text-blue-700 dark:text-blue-300 mb-4">Jumuiya Information</h3>
                    <dl class="space-y-4">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Name</dt>
                            <dd class="mt-1 text-gray-900 dark:text-gray-100 font-semibold">{{ $jumuiya->name }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Location</dt>
                            <dd class="mt-1 text-gray-900 dark:text-gray-100 font-semibold">{{ $jumuiya->location }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Chairperson</dt>
                            <dd class="mt-1 text-gray-900 dark:text-gray-100 font-semibold">{{ $jumuiya->chairperson->user->name ?? '-' }}</dd>
                        </div>
                    </dl>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
