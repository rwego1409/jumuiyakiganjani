@extends('layouts.app')

@section('content')
<div class="container mx-auto py-8 max-w-lg">
    <h1 class="text-2xl font-bold mb-6">Admin Details</h1>
    <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6 mb-6">
        <div class="mb-4">
            <span class="font-semibold">Name:</span> {{ $admin->name }}
        </div>
        <div class="mb-4">
            <span class="font-semibold">Email:</span> {{ $admin->email }}
        </div>
        <div class="mb-4">
            <span class="font-semibold">Phone:</span> {{ $admin->phone }}
        </div>
        <div class="mb-4">
            <span class="font-semibold">Status:</span> {{ ucfirst($admin->status ?? 'active') }}
        </div>
        <div class="mb-4">
            <span class="font-semibold">Assigned Jumuiyas:</span>
            <ul class="list-disc ml-6">
                @forelse($admin->managedJumuiyas as $jumuiya)
                    <li>{{ $jumuiya->name }}</li>
                @empty
                    <li>None</li>
                @endforelse
            </ul>
        </div>
        <div class="mb-4">
            <span class="font-semibold">Created:</span> {{ $admin->created_at->format('d M Y') }}
        </div>
    </div>
    <div class="flex space-x-2">
        <a href="{{ route('super_admin.admins.edit', $admin) }}" class="btn btn-warning">Edit</a>
        <form action="{{ route('super_admin.admins.destroy', $admin) }}" method="POST" onsubmit="return confirm('Are you sure?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">Delete</button>
        </form>
        <a href="{{ route('super_admin.admins.index') }}" class="btn btn-secondary">Back</a>
    </div>
</div>
@endsection
