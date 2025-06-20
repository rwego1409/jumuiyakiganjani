@extends('layouts.super_admin')

@section('content')
<div class="container mx-auto py-8 max-w-lg">
    <h1 class="text-2xl font-bold mb-6">Add Jumuiya</h1>
    <form method="POST" action="{{ route('super_admin.jumuiyas.store') }}">
        @csrf
        <div class="mb-4">
            <label class="block mb-1">Name</label>
            <input type="text" name="name" class="form-input w-full" value="{{ old('name') }}" required>
            @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>
        <div class="mb-4">
            <label class="block mb-1">Location</label>
            <input type="text" name="location" class="form-input w-full" value="{{ old('location') }}" required>
            @error('location') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>
        <div class="mb-4">
            <label class="block mb-1">Description</label>
            <textarea name="description" class="form-input w-full">{{ old('description') }}</textarea>
            @error('description') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>
        <div class="mb-4">
            <label class="block mb-1">Chairperson Email</label>
            <input type="email" name="chairperson_email" class="form-input w-full" value="{{ old('chairperson_email') }}" required>
            @error('chairperson_email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>
        <div class="flex justify-end">
            <button type="submit" class="btn btn-primary">Create Jumuiya</button>
        </div>
    </form>
</div>
@endsection
