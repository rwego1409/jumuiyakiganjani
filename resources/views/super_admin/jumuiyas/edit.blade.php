@extends('layouts.super_admin')

@section('content')
<div class="container mx-auto py-8 max-w-lg">
    <h1 class="text-2xl font-bold mb-6">Edit Jumuiya</h1>
    <form method="POST" action="{{ route('super_admin.jumuiyas.update', $jumuiya) }}">
        @csrf
        @method('PUT')
        <div class="mb-4">
            <label class="block mb-1">Name</label>
            <input type="text" name="name" class="form-input w-full" value="{{ old('name', $jumuiya->name) }}" required>
            @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>
        <div class="mb-4">
            <label class="block mb-1">Location</label>
            <input type="text" name="location" class="form-input w-full" value="{{ old('location', $jumuiya->location) }}" required>
            @error('location') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>
        <div class="mb-4">
            <label class="block mb-1">Description</label>
            <textarea name="description" class="form-input w-full">{{ old('description', $jumuiya->description) }}</textarea>
            @error('description') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>
        <div class="mb-4">
            <label class="block mb-1">Chairperson Name</label>
            <input type="text" name="chairperson_name" class="form-input w-full" value="{{ old('chairperson_name', $jumuiya->chairperson->name ?? '') }}" required>
            @error('chairperson_name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>
        <div class="flex justify-end">
            <button type="submit" class="btn btn-primary">Update Jumuiya</button>
        </div>
    </form>
</div>
@endsection
