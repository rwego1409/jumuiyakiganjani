@extends('layouts.admin')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-blue-100 dark:from-blue-900 dark:via-gray-800 dark:to-blue-900 py-12">
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-md shadow-2xl rounded-2xl border border-blue-200/50 dark:border-blue-900/50 p-8">
            <h1 class="text-3xl font-bold text-blue-700 dark:text-blue-300 mb-6 flex items-center gap-2 md:text-4xl lg:text-5xl">
                <svg class="w-8 h-8 text-blue-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87m13-6.13V7a4 4 0 00-3-3.87M6 4.13A4 4 0 019 4h6a4 4 0 013 3.87v2.13M12 14v6m0 0a2 2 0 01-2-2h4a2 2 0 01-2 2z"/></svg>
                Edit Member
            </h1>
            <form method="POST" action="{{ route('admin.members.update', $member->id) }}">
                @csrf
                @method('PUT')
                <div class="space-y-6">
                    <div>
                        <label for="name" class="block text-sm font-medium text-blue-700 dark:text-blue-300">Name</label>
                        <input type="text" name="name" id="name" value="{{ old('name', $member->user->name) }}" class="mt-1 block w-full rounded-lg border border-blue-200 dark:border-blue-700 bg-white/80 dark:bg-gray-700 text-gray-900 dark:text-gray-100 shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition" required>
                    </div>
                    <div>
                        <label for="email" class="block text-sm font-medium text-blue-700 dark:text-blue-300">Email</label>
                        <input type="email" name="email" id="email" value="{{ old('email', $member->user->email) }}" class="mt-1 block w-full rounded-lg border border-blue-200 dark:border-blue-700 bg-white/80 dark:bg-gray-700 text-gray-900 dark:text-gray-100 shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition" required>
                    </div>
                    <div>
                        <label for="jumuiya_id" class="block text-sm font-medium text-blue-700 dark:text-blue-300">Jumuiya</label>
                        <select name="jumuiya_id" id="jumuiya_id" class="mt-1 block w-full rounded-lg border border-blue-200 dark:border-blue-700 bg-white/80 dark:bg-gray-700 text-gray-900 dark:text-gray-100 shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition" required>
                            @foreach($jumuiyas as $jumuiya)
                                <option value="{{ $jumuiya->id }}" {{ $jumuiya->id == old('jumuiya_id', $member->jumuiya_id) ? 'selected' : '' }}>{{ $jumuiya->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="phone" class="block text-sm font-medium text-blue-700 dark:text-blue-300">Phone</label>
                        <input type="text" name="phone" id="phone" value="{{ old('phone', $member->phone) }}" class="mt-1 block w-full rounded-lg border border-blue-200 dark:border-blue-700 bg-white/80 dark:bg-gray-700 text-gray-900 dark:text-gray-100 shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition" required>
                    </div>
                    <div>
                        <label for="status" class="block text-sm font-medium text-blue-700 dark:text-blue-300">Status</label>
                        <select name="status" id="status" class="mt-1 block w-full rounded-lg border border-blue-200 dark:border-blue-700 bg-white/80 dark:bg-gray-700 text-gray-900 dark:text-gray-100 shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition" required>
                            <option value="active" {{ old('status', $member->status) == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ old('status', $member->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>
                    <div>
                        <label for="role" class="block text-sm font-medium text-blue-700 dark:text-blue-300">Role</label>
                        <select name="role" id="role" class="mt-1 block w-full rounded-lg border border-blue-200 dark:border-blue-700 bg-white/80 dark:bg-gray-700 text-gray-900 dark:text-gray-100 shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition" required>
                            <option value="member" {{ old('role', $member->user->role ?? 'member') == 'member' ? 'selected' : '' }}>Member</option>
                            <option value="chairperson" {{ old('role', $member->user->role ?? 'member') == 'chairperson' ? 'selected' : '' }}>Chairperson</option>
                            <option value="admin" {{ old('role', $member->user->role ?? 'member') == 'admin' ? 'selected' : '' }}>Admin</option>
                        </select>
                    </div>
                    <div class="pt-4">
                        <button type="submit" class="inline-flex justify-center py-2 px-6 rounded-xl shadow font-semibold text-white bg-gradient-to-r from-blue-600 to-blue-500 hover:from-blue-700 hover:to-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all">
                            Update Member
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
