@extends('layouts.super_admin')

@section('content')
<div class="container mx-auto py-8 max-w-lg">
    <h1 class="text-2xl font-bold mb-6">Chairperson Details</h1>
    <div class="bg-white shadow rounded-lg p-6">
        <div class="mb-4">
            <span class="font-semibold">Name:</span> {{ $chairperson->name }}
        </div>
        <div class="mb-4">
            <span class="font-semibold">Email:</span> {{ $chairperson->email }}
        </div>
        <div class="mb-4">
            <span class="font-semibold">Phone:</span> {{ $chairperson->phone }}
        </div>
        <div class="flex justify-end mt-6">
            <a href="{{ route('super_admin.chairpersons.edit', $chairperson) }}" class="btn btn-warning mr-2">Edit</a>
            <form action="{{ route('super_admin.chairpersons.destroy', $chairperson) }}" method="POST" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
            </form>
            <a href="{{ route('super_admin.chairpersons.index') }}" class="btn btn-secondary ml-2">Back</a>
        </div>
    </div>
</div>
@endsection
