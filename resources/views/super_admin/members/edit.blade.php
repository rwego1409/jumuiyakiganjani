@extends('layouts.super_admin')

@section('content')
<div class="container mx-auto py-8 max-w-lg px-2 sm:px-4">
    <h1 class="text-2xl font-bold mb-6 text-center sm:text-left">Edit Member</h1>
    <form method="POST" action="{{ route('super_admin.members.update', $member) }}" class="space-y-4">
        @csrf
        @method('PUT')
        <div class="mb-4">
            <label class="block mb-1 text-sm sm:text-base">Name</label>
            <input type="text" name="name" class="form-input w-full text-sm sm:text-base" value="{{ old('name', $member->user->name) }}" required>
            @error('name') <span class="text-red-500 text-xs sm:text-sm">{{ $message }}</span> @enderror
        </div>
        <div class="mb-4">
            <label class="block mb-1 text-sm sm:text-base">Email</label>
            <input type="email" name="email" class="form-input w-full text-sm sm:text-base" value="{{ old('email', $member->user->email) }}" required>
            @error('email') <span class="text-red-500 text-xs sm:text-sm">{{ $message }}</span> @enderror
        </div>
        <div class="mb-4">
            <label class="block mb-1 text-sm sm:text-base">Phone</label>
            <input type="text" name="phone" class="form-input w-full text-sm sm:text-base" value="{{ old('phone', $member->user->phone) }}" required>
            @error('phone') <span class="text-red-500 text-xs sm:text-sm">{{ $message }}</span> @enderror
        </div>
        <div class="mb-4">
            <label class="block mb-1 text-sm sm:text-base">Jumuiya</label>
            <select name="jumuiya_id" class="form-input w-full text-sm sm:text-base" required>
                <option value="">Select Jumuiya</option>
                @foreach($jumuiyas as $jumuiya)
                    <option value="{{ $jumuiya->id }}" {{ old('jumuiya_id', $member->jumuiya_id) == $jumuiya->id ? 'selected' : '' }}>{{ $jumuiya->name }}</option>
                @endforeach
            </select>
            @error('jumuiya_id') <span class="text-red-500 text-xs sm:text-sm">{{ $message }}</span> @enderror
        </div>
        <div class="mb-4">
            <label class="block mb-1 text-sm sm:text-base">Date of Birth</label>
            <input type="date" name="dob" class="form-input w-full text-sm sm:text-base" value="{{ old('dob', $member->dob) }}">
            @error('dob') <span class="text-red-500 text-xs sm:text-sm">{{ $message }}</span> @enderror
        </div>
        <div class="mb-4">
            <label class="block mb-1 text-sm sm:text-base">Gender</label>
            <select name="gender" class="form-input w-full text-sm sm:text-base">
                <option value="">Select Gender</option>
                <option value="male" {{ old('gender', $member->gender) == 'male' ? 'selected' : '' }}>Male</option>
                <option value="female" {{ old('gender', $member->gender) == 'female' ? 'selected' : '' }}>Female</option>
            </select>
            @error('gender') <span class="text-red-500 text-xs sm:text-sm">{{ $message }}</span> @enderror
        </div>
        <div class="mb-4">
            <label class="block mb-1 text-sm sm:text-base">Status</label>
            <select name="status" class="form-input w-full text-sm sm:text-base">
                <option value="active" {{ old('status', $member->status) == 'active' ? 'selected' : '' }}>Active</option>
                <option value="inactive" {{ old('status', $member->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
            </select>
            @error('status') <span class="text-red-500 text-xs sm:text-sm">{{ $message }}</span> @enderror
        </div>
        <button type="submit" class="btn btn-primary w-full sm:w-auto">Update Member</button>
    </form>
</div>
@endsection
