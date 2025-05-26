@extends('layouts.chairperson')

@section('content')
<div class="max-w-4xl mx-auto sm:px-6 lg:px-8 py-6">
    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6">
            <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200 mb-6">Create Notification</h2>

            @if(session('success'))
            <div class="mb-4 p-4 bg-green-100 border-l-4 border-green-500 text-green-700">
                {{ session('success') }}
            </div>
            @endif

            <form action="{{ route('chairperson.notifications.store') }}" method="POST" class="space-y-6">
                @csrf

                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Title
                    </label>
                    <input type="text" name="title" id="title" value="{{ old('title') }}"
                           class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-primary-500 focus:ring-primary-500">
                    @error('title')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="message" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Message
                    </label>
                    <textarea name="message" id="message" rows="4"
                              class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-primary-500 focus:ring-primary-500">{{ old('message') }}</textarea>
                    @error('message')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="type" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Type
                    </label>
                    <select name="type" id="type"
                            class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-primary-500 focus:ring-primary-500">
                        <option value="general" {{ old('type') == 'general' ? 'selected' : '' }}>General</option>
                        <option value="alert" {{ old('type') == 'alert' ? 'selected' : '' }}>Alert</option>
                        <option value="reminder" {{ old('type') == 'reminder' ? 'selected' : '' }}>Reminder</option>
                        <option value="update" {{ old('type') == 'update' ? 'selected' : '' }}>Update</option>
                    </select>
                    @error('type')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Recipients
                    </label>
                    <div class="mt-2 space-y-4">
                        <div class="flex items-center">
                            <input type="radio" name="recipient_type" id="all" value="all"
                                   {{ old('recipient_type', 'all') == 'all' ? 'checked' : '' }}
                                   class="focus:ring-primary-500 h-4 w-4 text-primary-600 border-gray-300 dark:border-gray-600">
                            <label for="all" class="ml-3 block text-sm font-medium text-gray-700 dark:text-gray-300">
                                All members of my Jumuiya
                            </label>
                        </div>
                        <div class="flex items-center">
                            <input type="radio" name="recipient_type" id="specific" value="specific"
                                   {{ old('recipient_type') == 'specific' ? 'checked' : '' }}
                                   class="focus:ring-primary-500 h-4 w-4 text-primary-600 border-gray-300 dark:border-gray-600">
                            <label for="specific" class="ml-3 block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Select specific members
                            </label>
                        </div>
                    </div>
                    @error('recipient_type')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div id="member-selection" class="hidden">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Select Members
                    </label>
                    <div class="mt-2 max-h-60 overflow-y-auto space-y-2">
                        @foreach($members as $member)
                            <div class="flex items-center">
                                <input type="checkbox" name="member_ids[]" value="{{ $member->id }}"
                                       {{ in_array($member->id, old('member_ids', [])) ? 'checked' : '' }}
                                       class="focus:ring-primary-500 h-4 w-4 text-primary-600 border-gray-300 dark:border-gray-600">
                                <label class="ml-3 text-sm text-gray-700 dark:text-gray-300">
                                    {{ $member->user->name }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                    @error('member_ids')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="action_url" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Action URL (Optional)
                    </label>
                    <input type="url" name="action_url" id="action_url" value="{{ old('action_url') }}"
                           class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-primary-500 focus:ring-primary-500"
                           placeholder="https://...">
                    @error('action_url')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-end">
                    <button type="submit"
                            class="px-4 py-2 bg-primary-600 text-white rounded-md hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                        Send Notification
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const recipientTypeInputs = document.querySelectorAll('input[name="recipient_type"]');
    const memberSelection = document.getElementById('member-selection');

    function toggleMemberSelection() {
        memberSelection.classList.toggle('hidden', 
            document.querySelector('input[name="recipient_type"]:checked').value !== 'specific');
    }

    recipientTypeInputs.forEach(input => {
        input.addEventListener('change', toggleMemberSelection);
    });

    toggleMemberSelection();
});
</script>
@endpush
@endsection
