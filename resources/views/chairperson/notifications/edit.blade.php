@extends('layouts.chairperson')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-pink-50 via-white to-purple-100 dark:from-pink-900 dark:via-gray-800 dark:to-purple-900 py-8 sm:py-12">
    <div class="max-w-3xl mx-auto px-2 sm:px-4 lg:px-8">
        <div class="bg-white/80 dark:bg-purple-900/80 backdrop-blur-md shadow-2xl rounded-2xl border border-pink-200/60 dark:border-purple-700/60 p-4 sm:p-8">
            <h2 class="text-2xl font-bold mb-6 text-gray-900 dark:text-white">Edit Notification</h2>
            @if ($errors->any())
                <div class="mb-4 p-4 bg-red-100 border-l-4 border-red-500 text-red-700">
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form method="POST" action="{{ route('chairperson.notifications.update', $notification->id) }}">
                @csrf
                @method('PUT')
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Title</label>
                    <input type="text" name="title" value="{{ old('title', $notification->title ?? $notification->data['title'] ?? '') }}" class="mt-1 block w-full rounded-xl border-gray-300 bg-slate-50 text-gray-900 focus:ring-violet-500 focus:border-violet-500">
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Message</label>
                    <textarea name="message" rows="4" class="mt-1 block w-full rounded-xl border-gray-300 bg-slate-50 text-gray-900 focus:ring-violet-500 focus:border-violet-500">{{ old('message', $notification->message ?? $notification->data['message'] ?? '') }}</textarea>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Type</label>
                    <select name="type" class="mt-1 block w-full rounded-xl border-gray-300 bg-slate-50 text-gray-900 focus:ring-violet-500 focus:border-violet-500">
                        <option value="general" {{ (old('type', $notification->type ?? $notification->data['type'] ?? '') == 'general') ? 'selected' : '' }}>General</option>
                        <option value="alert" {{ (old('type', $notification->type ?? $notification->data['type'] ?? '') == 'alert') ? 'selected' : '' }}>Alert</option>
                        <option value="reminder" {{ (old('type', $notification->type ?? $notification->data['type'] ?? '') == 'reminder') ? 'selected' : '' }}>Reminder</option>
                        <option value="update" {{ (old('type', $notification->type ?? $notification->data['type'] ?? '') == 'update') ? 'selected' : '' }}>Update</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Recipient Type</label>
                    <select name="recipient_type" id="recipient_type" class="mt-1 block w-full rounded-xl border-gray-300 bg-slate-50 text-gray-900 focus:ring-violet-500 focus:border-violet-500" onchange="document.getElementById('member-select').style.display = this.value === 'specific' ? 'block' : 'none';">
                        <option value="all" {{ (old('recipient_type', $notification->recipient_type ?? $notification->data['recipient_type'] ?? '') == 'all') ? 'selected' : '' }}>All Members</option>
                        <option value="specific" {{ (old('recipient_type', $notification->recipient_type ?? $notification->data['recipient_type'] ?? '') == 'specific') ? 'selected' : '' }}>Specific Members</option>
                    </select>
                </div>
                <div class="mb-4" id="member-select" style="display: {{ (old('recipient_type', $notification->recipient_type ?? $notification->data['recipient_type'] ?? '') == 'specific') ? 'block' : 'none' }};">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Select Members</label>
                    <select name="member_ids[]" multiple class="mt-1 block w-full rounded-xl border-gray-300 bg-slate-50 text-gray-900 focus:ring-violet-500 focus:border-violet-500">
                        @foreach($members as $member)
                            <option value="{{ $member->id }}" {{ (collect(old('member_ids', $notification->member_ids ?? $notification->data['member_ids'] ?? []))->contains($member->id)) ? 'selected' : '' }}>
                                {{ $member->user->name ?? 'Member #'.$member->id }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Action URL (optional)</label>
                    <input type="url" name="action_url" value="{{ old('action_url', $notification->action_url ?? $notification->data['action_url'] ?? '') }}" class="mt-1 block w-full rounded-xl border-gray-300 bg-slate-50 text-gray-900 focus:ring-violet-500 focus:border-violet-500">
                </div>
                <div class="flex justify-end">
                    <a href="{{ route('chairperson.notifications.index') }}" class="mr-4 px-4 py-2 bg-gray-200 text-gray-700 rounded-xl font-semibold shadow hover:bg-gray-300">Cancel</a>
                    <button type="submit" class="px-6 py-2 bg-gradient-to-r from-pink-500 to-purple-600 text-white font-bold rounded-xl shadow hover:from-pink-600 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-pink-400">Update Notification</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
