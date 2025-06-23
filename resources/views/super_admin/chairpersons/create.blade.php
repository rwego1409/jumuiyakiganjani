@extends('layouts.super_admin')

@section('content')
<div class="container mx-auto py-8 max-w-lg px-2 sm:px-4">
    <h1 class="text-2xl font-bold mb-6 text-center sm:text-left">Add Chairperson</h1>
    <form action="{{ route('super_admin.chairpersons.store') }}" method="POST" class="bg-white shadow rounded-lg p-6 space-y-4">
        @csrf
        <div class="mb-4">
            <label class="block mb-1 font-semibold text-sm sm:text-base">Name</label>
            <input type="text" name="name" class="form-input w-full text-sm sm:text-base" value="{{ old('name') }}" required>
            @error('name')<div class="text-red-500 text-xs sm:text-sm">{{ $message }}</div>@enderror
        </div>
        <div class="mb-4">
            <label class="block mb-1 font-semibold text-sm sm:text-base">Email</label>
            <input type="email" name="email" class="form-input w-full text-sm sm:text-base" value="{{ old('email') }}" required>
            @error('email')<div class="text-red-500 text-xs sm:text-sm">{{ $message }}</div>@enderror
        </div>
        <div class="mb-4">
            <label class="block mb-1 font-semibold text-sm sm:text-base">Phone</label>
            <input type="text" name="phone" class="form-input w-full text-sm sm:text-base" value="{{ old('phone') }}" required>
            @error('phone')<div class="text-red-500 text-xs sm:text-sm">{{ $message }}</div>@enderror
        </div>
        <div class="mb-4">
            <label class="block mb-1 font-semibold text-sm sm:text-base">Password</label>
            <input type="password" name="password" class="form-input w-full text-sm sm:text-base" required>
            @error('password')<div class="text-red-500 text-xs sm:text-sm">{{ $message }}</div>@enderror
        </div>
        <div class="mb-6">
            <label class="block mb-1 font-semibold text-sm sm:text-base">Confirm Password</label>
            <input type="password" name="password_confirmation" class="form-input w-full text-sm sm:text-base" required>
        </div>
        <div class="flex flex-col sm:flex-row justify-end gap-2 sm:gap-0 sm:space-x-2 w-full sm:w-auto">
            <a href="{{ route('super_admin.chairpersons.index') }}" class="btn btn-secondary w-full sm:w-auto">Cancel</a>
            <button type="submit" class="btn btn-primary w-full sm:w-auto">Create</button>
        </div>
    </form>
</div>
@endsection
