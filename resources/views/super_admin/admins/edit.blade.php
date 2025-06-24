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
            <h1 class="text-2xl font-extrabold bg-gradient-to-r from-pink-600 to-indigo-500 bg-clip-text text-transparent drop-shadow-lg">Edit Admin</h1>
            <p class="text-gray-600 dark:text-gray-300 text-sm mt-1">Update admin details below</p>
        </div>
        <form method="POST" action="{{ route('super_admin.admins.update', $admin) }}" class="space-y-6">
            @csrf
            @method('PUT')
            <!-- Name Field -->
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">Full Name</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400 dark:text-gray-300" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <input type="text" name="name" value="{{ old('name', $admin->name) }}" required
                        class="pl-10 block w-full rounded-md border-gray-300 dark:border-gray-600 bg-white/70 dark:bg-gray-900/60 shadow-sm focus:border-pink-500 focus:ring-pink-500 sm:text-sm py-2 text-gray-900 dark:text-white"
                        placeholder="Admin name">
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
                    <input type="email" name="email" value="{{ old('email', $admin->email) }}" required
                        class="pl-10 block w-full rounded-md border-gray-300 dark:border-gray-600 bg-white/70 dark:bg-gray-900/60 shadow-sm focus:border-pink-500 focus:ring-pink-500 sm:text-sm py-2 text-gray-900 dark:text-white"
                        placeholder="admin@example.com">
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
                    <input type="text" name="phone" value="{{ old('phone', $admin->phone) }}" required
                        class="pl-10 block w-full rounded-md border-gray-300 dark:border-gray-600 bg-white/70 dark:bg-gray-900/60 shadow-sm focus:border-pink-500 focus:ring-pink-500 sm:text-sm py-2 text-gray-900 dark:text-white"
                        placeholder="+255 123 456 789">
                </div>
                @error('phone') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
            <!-- Password Field -->
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">
                    Password <span class="text-xs font-normal text-gray-500 dark:text-gray-400">(leave blank to keep current)</span>
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400 dark:text-gray-300" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <input type="password" name="password"
                        class="pl-10 block w-full rounded-md border-gray-300 dark:border-gray-600 bg-white/70 dark:bg-gray-900/60 shadow-sm focus:border-pink-500 focus:ring-pink-500 sm:text-sm py-2 text-gray-900 dark:text-white"
                        placeholder="••••••••">
                </div>
                @error('password') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
            <!-- Jumuiyas Field -->
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">Assigned Jumuiyas</label>
                <select name="assigned_jumuiyas[]" multiple
                    class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 dark:border-gray-600 bg-white/70 dark:bg-gray-900/60 focus:outline-none focus:ring-pink-500 focus:border-pink-500 sm:text-sm rounded-md h-auto text-gray-900 dark:text-white">
                    @foreach($jumuiyas as $jumuiya)
                        <option value="{{ $jumuiya->id }}" {{ in_array($jumuiya->id, $assignedJumuiyas ?? []) ? 'selected' : '' }} class="py-1">
                            {{ $jumuiya->name }}
                        </option>
                    @endforeach
                </select>
                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Hold Ctrl/Cmd to select multiple</p>
                @error('assigned_jumuiyas') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
            <!-- Status Field -->
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">Account Status</label>
                <div class="mt-1">
                    <select name="status" class="block w-full pl-3 pr-10 py-2 text-base border-gray-300 dark:border-gray-600 bg-white/70 dark:bg-gray-900/60 focus:outline-none focus:ring-pink-500 focus:border-pink-500 sm:text-sm rounded-md text-gray-900 dark:text-white">
                        <option value="active" {{ old('status', $admin->status ?? 'active') == 'active' ? 'selected' : '' }} class="text-green-600">Active</option>
                        <option value="inactive" {{ old('status', $admin->status ?? 'active') == 'inactive' ? 'selected' : '' }} class="text-red-600">Inactive</option>
                    </select>
                </div>
                @error('status') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
            <!-- Submit Button -->
            <div class="pt-4">
                <div class="flex justify-end space-x-3">
                    <a href="{{ route('super_admin.admins.index') }}" class="inline-flex justify-center items-center py-2.5 px-4 rounded-2xl font-bold text-gray-700 dark:text-white bg-gradient-to-r from-gray-100 to-gray-300 dark:from-gray-800 dark:to-gray-700 shadow-xl hover:from-gray-200 hover:to-gray-400 dark:hover:from-gray-700 dark:hover:to-gray-900 focus:outline-none focus:ring-2 focus:ring-pink-400 transition-all duration-300">
                        <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                        Cancel
                    </a>
                    <button type="submit" class="inline-flex justify-center items-center py-2.5 px-4 rounded-2xl font-bold text-white bg-gradient-to-r from-pink-500 via-violet-600 to-indigo-600 shadow-xl shadow-pink-500/10 dark:shadow-violet-500/20 hover:from-pink-600 hover:via-violet-700 hover:to-indigo-700 dark:from-pink-400 dark:via-violet-500 dark:to-indigo-500 dark:hover:from-pink-500 dark:hover:via-violet-600 dark:hover:to-indigo-600 transition-all duration-300 hover:scale-105 hover:shadow-2xl focus:outline-none focus:ring-2 focus:ring-pink-400">
                        <svg class="-ml-1 mr-2 h-5 w-5 transition-transform group-hover:rotate-90" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Update Admin
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- Glassmorphism utility -->
<style>
    .glass-card {
        background: rgba(255,255,255,0.65);
        border-radius: 1rem;
        box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.18);
        border: 1px solid rgba(255,255,255,0.18);
        backdrop-filter: blur(8px);
    }
    @media (prefers-color-scheme: dark) {
        .glass-card {
            background: rgba(30,41,59,0.65);
            border: 1px solid rgba(51,65,85,0.18);
        }
    }
</style>
@endsection