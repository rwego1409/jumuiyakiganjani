@extends('layouts.chairperson')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-pink-50 via-white to-purple-100 dark:from-pink-900 dark:via-gray-800 dark:to-purple-900 py-12">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white/80 dark:bg-purple-900/80 backdrop-blur-md shadow-2xl rounded-2xl border border-pink-200/60 dark:border-purple-700/60 p-8">
            <div class="mb-6 flex items-center gap-3">
                <svg class="w-8 h-8 text-pink-500 dark:text-pink-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                <h2 class="text-2xl font-bold bg-gradient-to-r from-pink-600 to-purple-600 bg-clip-text text-transparent drop-shadow-lg">{{ __('Edit Member') }}</h2>
            </div>
            <!-- Member edit form here -->
            <form method="POST" action="{{ route('chairperson.members.update', $member->id) }}" class="space-y-6">
                @csrf
                @method('PUT')
                <div class="mb-4">
                    <label class="block mb-1 text-sm font-medium text-pink-700 dark:text-pink-200">Full Name</label>
                    <input type="text" name="name" value="{{ old('name', $member->user->name) }}" required class="form-input w-full text-sm" />
                    @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
                <div class="mb-4">
                    <label class="block mb-1 text-sm font-medium text-pink-700 dark:text-pink-200">Email</label>
                    <input type="email" name="email" value="{{ old('email', $member->user->email) }}" required class="form-input w-full text-sm" />
                    @error('email') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
                <div class="mb-4">
                    <label class="block mb-1 text-sm font-medium text-pink-700 dark:text-pink-200">Phone</label>
                    <input type="text" name="phone" value="{{ old('phone', $member->phone) }}" required class="form-input w-full text-sm" />
                    @error('phone') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
                <div class="mb-4">
                    <label class="block mb-1 text-sm font-medium text-pink-700 dark:text-pink-200">Status</label>
                    <select name="status" class="form-input w-full text-sm">
                        <option value="active" {{ old('status', $member->status) == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ old('status', $member->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                    @error('status') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
                <div class="mb-4">
                    <label class="block mb-1 text-sm font-medium text-pink-700 dark:text-pink-200">Joined Date</label>
                    <input type="date" name="joined_date" value="{{ old('joined_date', optional($member->joined_date)->format('Y-m-d')) }}" class="form-input w-full text-sm" />
                    @error('joined_date') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
                <div class="flex justify-end">
                    <button type="submit" class="bg-pink-600 hover:bg-pink-700 text-white font-bold py-2 px-6 rounded shadow">Update Member</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection