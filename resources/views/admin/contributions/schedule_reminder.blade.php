@extends('layouts.admin')

@section('content')
<div class="py-6">
    <div class="max-w-md mx-auto bg-white rounded-lg shadow-md p-6">
        <h2 class="text-2xl font-semibold text-gray-800 mb-6">Schedule Reminder</h2>
        
        <form action="{{ route('admin.contributions.scheduleReminder', $contribution) }}" method="POST">
            @csrf
            
            <div class="mb-4">
                <label for="reminder_date" class="block text-gray-700 font-medium mb-2">Reminder Date</label>
                <input type="datetime-local" name="reminder_date" id="reminder_date" 
                       class="w-full p-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                       required>
                @error('reminder_date')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="mt-6">
                <button type="submit" 
                        class="w-full bg-indigo-600 text-white py-3 px-4 rounded-lg hover:bg-indigo-700 transition duration-200">
                    Schedule Reminder
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
