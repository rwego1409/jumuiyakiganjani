@extends('layouts.app')

@section('content')
<div class="container mx-auto py-8 max-w-lg">
    <h1 class="text-2xl font-bold mb-6">Jumuiya Details</h1>
    <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6 mb-6">
        <div class="mb-4">
            <span class="font-semibold">Name:</span> {{ $jumuiya->name }}
        </div>
        <div class="mb-4">
            <span class="font-semibold">Location:</span> {{ $jumuiya->location }}
        </div>
        <div class="mb-4">
            <span class="font-semibold">Description:</span> {{ $jumuiya->description ?? '-' }}
        </div>
        <div class="mb-4">
            <span class="font-semibold">Chairperson:</span> {{ $jumuiya->chairperson->name ?? '-' }}
        </div>
        <div class="mb-4">
            <span class="font-semibold">Created:</span> {{ $jumuiya->created_at->format('d M Y') }}
        </div>
    </div>
    <div class="flex space-x-2">
        <a href="{{ route('super_admin.jumuiyas.edit', $jumuiya) }}" class="btn btn-warning">Edit</a>
        <form action="{{ route('super_admin.jumuiyas.destroy', $jumuiya) }}" method="POST" onsubmit="return confirm('Are you sure?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">Delete</button>
        </form>
        <a href="{{ route('super_admin.jumuiyas.index') }}" class="btn btn-secondary">Back</a>
    </div>
</div>
@endsection
