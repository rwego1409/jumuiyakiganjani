@extends('layouts.super_admin')

@section('content')
<div class="container mx-auto py-8 max-w-lg px-2 sm:px-4">
    <h1 class="text-2xl font-bold mb-6 text-center sm:text-left">Add Jumuiya</h1>
    <form method="POST" action="{{ route('super_admin.jumuiyas.store') }}" class="space-y-4">
        @csrf
        <div class="mb-4">
            <label class="block mb-1 text-sm sm:text-base">Name</label>
            <input type="text" name="name" class="form-input w-full text-sm sm:text-base" value="{{ old('name') }}" required>
            @error('name') <span class="text-red-500 text-xs sm:text-sm">{{ $message }}</span> @enderror
        </div>
        <div class="mb-4">
            <label class="block mb-1 text-sm sm:text-base">Location</label>
            <input type="text" name="location" class="form-input w-full text-sm sm:text-base" value="{{ old('location') }}" required>
            @error('location') <span class="text-red-500 text-xs sm:text-sm">{{ $message }}</span> @enderror
        </div>
        <div class="mb-4">
            <label class="block mb-1 text-sm sm:text-base">Description</label>
            <textarea name="description" class="form-input w-full text-sm sm:text-base" rows="3">{{ old('description') }}</textarea>
            @error('description') <span class="text-red-500 text-xs sm:text-sm">{{ $message }}</span> @enderror
        </div>
        <div class="mb-4">
            <label class="block mb-1 text-sm sm:text-base">Chairperson Email</label>
            <input type="email" name="chairperson_email" class="form-input w-full text-sm sm:text-base" value="{{ old('chairperson_email') }}" required>
            @error('chairperson_email') <span class="text-red-500 text-xs sm:text-sm">{{ $message }}</span> @enderror
        </div>
        <div class="flex flex-col sm:flex-row gap-2 justify-end">
            <button type="submit" class="btn btn-primary w-full sm:w-auto">Create Jumuiya</button>
        </div>
    </form>
</div>
@endsection
