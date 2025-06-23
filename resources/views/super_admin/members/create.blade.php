@extends('layouts.super_admin')

@section('content')
<div class="container mx-auto py-8 max-w-lg px-2 sm:px-4">
    <h1 class="text-2xl font-bold mb-6 text-center sm:text-left">Add Member</h1>
    <form method="POST" action="{{ route('super_admin.members.store') }}" class="space-y-4">
        @csrf
        <div class="mb-4">
            <label class="block mb-1 text-sm sm:text-base">Name</label>
            <input type="text" name="name" class="form-input w-full text-sm sm:text-base" value="{{ old('name') }}" required>
            @error('name') <span class="text-red-500 text-xs sm:text-sm">{{ $message }}</span> @enderror
        </div>
        <div class="mb-4">
            <label class="block mb-1 text-sm sm:text-base">Email</label>
            <input type="email" name="email" class="form-input w-full text-sm sm:text-base" value="{{ old('email') }}" required>
            @error('email') <span class="text-red-500 text-xs sm:text-sm">{{ $message }}</span> @enderror
        </div>
        <div class="mb-4">
            <label class="block mb-1 text-sm sm:text-base">Phone</label>
            <input type="text" name="phone" class="form-input w-full text-sm sm:text-base" value="{{ old('phone') }}" required>
            @error('phone') <span class="text-red-500 text-xs sm:text-sm">{{ $message }}</span> @enderror
        </div>
        <div class="mb-4">
            <label class="block mb-1 text-sm sm:text-base">Jumuiya</label>
            <select name="jumuiya_id" class="form-input w-full text-sm sm:text-base" required>
                <option value="">Select Jumuiya</option>
                @foreach($jumuiyas as $jumuiya)
                    <option value="{{ $jumuiya->id }}" {{ old('jumuiya_id') == $jumuiya->id ? 'selected' : '' }}>{{ $jumuiya->name }}</option>
                @endforeach
            </select>
            @error('jumuiya_id') <span class="text-red-500 text-xs sm:text-sm">{{ $message }}</span> @enderror
        </div>
        <div class="mb-4">
            <label class="block mb-1 text-sm sm:text-base">Date of Birth</label>
            <input type="date" name="dob" class="form-input w-full text-sm sm:text-base" value="{{ old('dob') }}">
            @error('dob') <span class="text-red-500 text-xs sm:text-sm">{{ $message }}</span> @enderror
        </div>
        <div class="mb-4">
            <label class="block mb-1 text-sm sm:text-base">Gender</label>
            <select name="gender" class="form-input w-full text-sm sm:text-base">
                <option value="">Select Gender</option>
                <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
            </select>
            @error('gender') <span class="text-red-500 text-xs sm:text-sm">{{ $message }}</span> @enderror
        </div>
        <div class="mb-4">
            <label class="block mb-1 text-sm sm:text-base">Password</label>
            <input type="password" name="password" class="form-input w-full text-sm sm:text-base" required>
            @error('password') <span class="text-red-500 text-xs sm:text-sm">{{ $message }}</span> @enderror
        </div>
        <div class="mb-4">
            <label class="block mb-1 text-sm sm:text-base">Confirm Password</label>
            <input type="password" name="password_confirmation" class="form-input w-full text-sm sm:text-base" required>
        </div>
        <div class="mb-4">
            <label class="block mb-1 text-sm sm:text-base">Status</label>
            <select name="status" class="form-input w-full text-sm sm:text-base">
                <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
            </select>
            @error('status') <span class="text-red-500 text-xs sm:text-sm">{{ $message }}</span> @enderror
        </div>
        <button type="submit" class="btn btn-primary w-full sm:w-auto">Create Member</button>
    </form>
</div>
@endsection
