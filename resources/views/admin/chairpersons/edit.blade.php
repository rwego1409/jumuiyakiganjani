@extends('layouts.admin')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-blue-100 dark:from-blue-900 dark:via-gray-800 dark:to-blue-900 py-12">
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-md shadow-2xl rounded-2xl border border-blue-200/50 dark:border-blue-900/50 p-8">
            <h1 class="text-3xl font-bold text-blue-700 dark:text-blue-300 mb-6">Edit Chairperson</h1>
            <form method="POST" action="{{ route('admin.chairpersons.update', $chairperson->id) }}">
                @csrf
                @method('PUT')
                <div class="space-y-6">
                    <div>
                        <label for="name" class="block text-sm font-medium text-blue-700 dark:text-blue-300">Name</label>
                        <input type="text" name="name" id="name" value="{{ old('name', $chairperson->name) }}" class="mt-1 block w-full rounded-lg border border-blue-200 dark:border-blue-700 bg-white/80 dark:bg-gray-700 text-gray-900 dark:text-gray-100 shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition" required>
                    </div>
                    <div>
                        <label for="email" class="block text-sm font-medium text-blue-700 dark:text-blue-300">Email</label>
                        <input type="email" name="email" id="email" value="{{ old('email', $chairperson->email) }}" class="mt-1 block w-full rounded-lg border border-blue-200 dark:border-blue-700 bg-white/80 dark:bg-gray-700 text-gray-900 dark:text-gray-100 shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition" required>
                    </div>
                    <div>
                        <label for="phone" class="block text-sm font-medium text-blue-700 dark:text-blue-300">Phone</label>
                        <input type="text" name="phone" id="phone" value="{{ old('phone', $chairperson->phone) }}" class="mt-1 block w-full rounded-lg border border-blue-200 dark:border-blue-700 bg-white/80 dark:bg-gray-700 text-gray-900 dark:text-gray-100 shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition" required>
                    </div>
                    <div class="pt-4">
                        <button type="submit" class="inline-flex justify-center py-2 px-6 rounded-xl shadow font-semibold text-white bg-gradient-to-r from-blue-600 to-blue-500 hover:from-blue-700 hover:to-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all">
                            Update Chairperson
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
