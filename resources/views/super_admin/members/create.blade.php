@extends('layouts.app')

@section('content')
<div class="container mx-auto py-8 max-w-lg">
    <h1 class="text-2xl font-bold mb-6">Add Member</h1>
    <form method="POST" action="{{ route('super_admin.members.store') }}">
        @csrf
        <div class="mb-4">
            <label class="block mb-1">Name</label>
            <input type="text" name="name" class="form-input w-full" value="{{ old('name') }}" required>
            @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>
        <div class="mb-4">
            <label class="block mb-1">Email</label>
            <input type="email" name="email" class="form-input w-full" value="{{ old('email') }}" required>
            @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>
        <div class="mb-4">
            <label class="block mb-1">Phone</label>
            <input type="text" name="phone" class="form-input w-full" value="{{ old('phone') }}" required>
            @error('phone') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>
        <div class="mb-4">
            <label class="block mb-1">Jumuiya</label>
            <select name="jumuiya_id" class="form-input w-full" required>
                <option value="">Select Jumuiya</option>
                @foreach($jumuiyas as $jumuiya)
                    <option value="{{ $jumuiya->id }}" {{ old('jumuiya_id') == $jumuiya->id ? 'selected' : '' }}>{{ $jumuiya->name }}</option>
                @endforeach
            </select>
            @error('jumuiya_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>
        <div class="mb-4">
            <label class="block mb-1">Date of Birth</label>
            <input type="date" name="dob" class="form-input w-full" value="{{ old('dob') }}">
            @error('dob') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>
        <div class="mb-4">
            <label class="block mb-1">Gender</label>
            <select name="gender" class="form-input w-full">
                <option value="">Select Gender</option>
                <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
            </select>
            @error('gender') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>
        <div class="mb-4">
            <label class="block mb-1">Password</label>
            <input type="password" name="password" class="form-input w-full" required>
            @error('password') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>
        <div class="mb-4">
            <label class="block mb-1">Confirm Password</label>
            <input type="password" name="password_confirmation" class="form-input w-full" required>
        </div>
        <div class="mb-4">
            <label class="block mb-1">Status</label>
            <select name="status" class="form-input w-full">
                <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
            </select>
            @error('status') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>
        <button type="submit" class="btn btn-primary w-full">Create Member</button>
    </form>
</div>
@endsection
