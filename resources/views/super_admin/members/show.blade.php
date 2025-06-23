@extends('layouts.super_admin')

@section('content')
<div class="max-w-lg mx-auto px-2 sm:px-4 py-4 sm:py-8">
    <h1 class="text-xl sm:text-2xl font-bold mb-4 sm:mb-6">Member Details</h1>
    <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-4 sm:p-6">
        <div class="mb-2 sm:mb-4 text-xs sm:text-sm">
            <strong>Name:</strong> {{ $member->user->name }}
        </div>
        <div class="mb-2 sm:mb-4 text-xs sm:text-sm">
            <strong>Email:</strong> {{ $member->user->email }}
        </div>
        <div class="mb-2 sm:mb-4 text-xs sm:text-sm">
            <strong>Phone:</strong> {{ $member->user->phone }}
        </div>
        <div class="mb-2 sm:mb-4 text-xs sm:text-sm">
            <strong>Jumuiya:</strong> {{ $member->jumuiya->name ?? '-' }}
        </div>
        <div class="mb-2 sm:mb-4 text-xs sm:text-sm">
            <strong>Date of Birth:</strong> {{ $member->dob ?? '-' }}
        </div>
        <div class="mb-2 sm:mb-4 text-xs sm:text-sm">
            <strong>Gender:</strong> {{ ucfirst($member->gender) ?? '-' }}
        </div>
        <div class="mb-2 sm:mb-4 text-xs sm:text-sm">
            <strong>Status:</strong> {{ ucfirst($member->status) ?? '-' }}
        </div>
        <div class="flex flex-col sm:flex-row gap-2 sm:space-x-2 mt-4 sm:mt-6 w-full sm:w-auto">
            <a href="{{ route('super_admin.members.edit', $member) }}" class="btn btn-warning w-full sm:w-auto">Edit</a>
            <form action="{{ route('super_admin.members.destroy', $member) }}" method="POST" onsubmit="return confirm('Are you sure?')" class="w-full sm:w-auto">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger w-full sm:w-auto">Delete</button>
            </form>
            <a href="{{ route('super_admin.members.index') }}" class="btn btn-secondary w-full sm:w-auto">Back</a>
        </div>
    </div>
</div>
@endsection
