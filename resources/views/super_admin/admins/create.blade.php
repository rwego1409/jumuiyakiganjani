@extends('layouts.super_admin')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-slate-50/80 to-blue-100/60 dark:from-gray-900/80 dark:to-blue-900/60 py-8 px-2">
    <div class="glass-card max-w-lg w-full mx-auto p-8">
        <div class="mb-8 flex flex-col items-center">
            <div class="bg-gradient-to-r from-pink-500 to-indigo-500 p-3 rounded-full mb-3 shadow-lg">
                <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
            </div>
            <h1 class="text-2xl font-extrabold bg-gradient-to-r from-pink-600 to-indigo-500 bg-clip-text text-transparent drop-shadow-lg">Create New Admin</h1>
            <p class="text-gray-600 dark:text-gray-300 text-sm mt-1">Fill in the details to add a new admin user</p>
        </div>

        <form method="POST" action="{{ route('super_admin.admins.store') }}" class="space-y-6">
            @csrf
            <!-- Name Field -->
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">Full Name</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400 dark:text-gray-300" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <input type="text" name="name" value="{{ old('name') }}" required
                        class="pl-10 block w-full rounded-md border-gray-300 dark:border-gray-600 bg-white/70 dark:bg-gray-900/60 shadow-sm focus:border-pink-500 focus:ring-pink-500 sm:text-sm py-2 text-gray-900 dark:text-white"
                        placeholder="John Doe">
                </div>
                @error('name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
            <!-- Email Field -->
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">Email Address</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400 dark:text-gray-300" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                            <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                        </svg>
                    </div>
                    <input type="email" name="email" value="{{ old('email') }}" required
                        class="pl-10 block w-full rounded-md border-gray-300 dark:border-gray-600 bg-white/70 dark:bg-gray-900/60 shadow-sm focus:border-pink-500 focus:ring-pink-500 sm:text-sm py-2 text-gray-900 dark:text-white"
                        placeholder="john@example.com">
                </div>
                @error('email') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
            <!-- Phone Field -->
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">Phone Number</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400 dark:text-gray-300" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z" />
                        </svg>
                    </div>
                    <input type="text" name="phone" value="{{ old('phone') }}" required
                        class="pl-10 block w-full rounded-md border-gray-300 dark:border-gray-600 bg-white/70 dark:bg-gray-900/60 shadow-sm focus:border-pink-500 focus:ring-pink-500 sm:text-sm py-2 text-gray-900 dark:text-white"
                        placeholder="+255 123 456 789">
                </div>
                @error('phone') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
            <!-- Password Field -->
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">Password</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400 dark:text-gray-300" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <input type="password" name="password" required
                        class="pl-10 block w-full rounded-md border-gray-300 dark:border-gray-600 bg-white/70 dark:bg-gray-900/60 shadow-sm focus:border-pink-500 focus:ring-pink-500 sm:text-sm py-2 text-gray-900 dark:text-white"
                        placeholder="••••••••">
                </div>
                @error('password') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
            <!-- Jumuiyas Field -->
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">Assign Jumuiyas</label>
                <select name="assigned_jumuiyas[]" multiple
                    class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 dark:border-gray-600 bg-white/70 dark:bg-gray-900/60 focus:outline-none focus:ring-pink-500 focus:border-pink-500 sm:text-sm rounded-md h-auto text-gray-900 dark:text-white">
                    @foreach($jumuiyas as $jumuiya)
                        <option value="{{ $jumuiya->id }}" class="py-1">{{ $jumuiya->name }}</option>
                    @endforeach
                </select>
                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Hold Ctrl/Cmd to select multiple</p>
                @error('assigned_jumuiyas') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
            <!-- Submit Button -->
            <div class="pt-2">
                <button type="submit" 
                    class="w-full flex justify-center items-center py-2.5 px-4 rounded-lg font-bold text-white bg-gradient-to-r from-pink-500 to-indigo-500 shadow-lg hover:from-pink-600 hover:to-indigo-600 focus:outline-none focus:ring-2 focus:ring-pink-400 transition-all">
                    <svg class="mr-2 w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                    Create Admin
                </button>
            </div>
        </form>
    </div>
</div>
@endsection