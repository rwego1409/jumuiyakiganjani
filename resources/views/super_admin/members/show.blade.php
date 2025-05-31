@extends('layouts.app')

@section('content')
<div class="container mx-auto py-8 max-w-lg">
    <h1 class="text-2xl font-bold mb-6">Member Details</h1>
    <div class="bg-white shadow rounded-lg p-6">
        <div class="mb-4">
            <strong>Name:</strong> {{ $member->user->name }}
        </div>
        <div class="mb-4">
            <strong>Email:</strong> {{ $member->user->email }}
        </div>
        <div class="mb-4">
            <strong>Phone:</strong> {{ $member->user->phone }}
        </div>
        <div class="mb-4">
            <strong>Jumuiya:</strong> {{ $member->jumuiya->name ?? '-' }}
        </div>
        <div class="mb-4">
            <strong>Date of Birth:</strong> {{ $member->dob ?? '-' }}
        </div>
        <div class="mb-4">
            <strong>Gender:</strong> {{ ucfirst($member->gender) ?? '-' }}
        </div>
        <div class="mb-4">
            <strong>Status:</strong> {{ ucfirst($member->status) ?? '-' }}
        </div>
        <div class="flex space-x-2 mt-6">
            <a href="{{ route('super_admin.members.edit', $member) }}" class="btn btn-warning">Edit</a>
            <form action="{{ route('super_admin.members.destroy', $member) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Delete</button>
            </form>
            <a href="{{ route('super_admin.members.index') }}" class="btn btn-secondary">Back</a>
        </div>
    </div>
</div>
@endsection
