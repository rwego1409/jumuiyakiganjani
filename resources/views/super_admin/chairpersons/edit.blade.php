@extends('layouts.app')

@section('content')
<div class="container mx-auto py-8 max-w-lg">
    <h1 class="text-2xl font-bold mb-6">Edit Chairperson</h1>
    <form action="{{ route('super_admin.chairpersons.update', $chairperson) }}" method="POST" class="bg-white shadow rounded-lg p-6">
        @csrf
        @method('PUT')
        <div class="mb-4">
            <label class="block mb-1 font-semibold">Name</label>
            <input type="text" name="name" class="form-input w-full" value="{{ old('name', $chairperson->name) }}" required>
            @error('name')<div class="text-red-500 text-sm">{{ $message }}</div>@enderror
        </div>
        <div class="mb-4">
            <label class="block mb-1 font-semibold">Email</label>
            <input type="email" name="email" class="form-input w-full" value="{{ old('email', $chairperson->email) }}" required>
            @error('email')<div class="text-red-500 text-sm">{{ $message }}</div>@enderror
        </div>
        <div class="mb-4">
            <label class="block mb-1 font-semibold">Phone</label>
            <input type="text" name="phone" class="form-input w-full" value="{{ old('phone', $chairperson->phone) }}" required>
            @error('phone')<div class="text-red-500 text-sm">{{ $message }}</div>@enderror
        </div>
        <div class="mb-4">
            <label class="block mb-1 font-semibold">Password <span class="text-gray-500 text-xs">(leave blank to keep current)</span></label>
            <input type="password" name="password" class="form-input w-full">
            @error('password')<div class="text-red-500 text-sm">{{ $message }}</div>@enderror
        </div>
        <div class="mb-6">
            <label class="block mb-1 font-semibold">Confirm Password</label>
            <input type="password" name="password_confirmation" class="form-input w-full">
        </div>
        <div class="flex justify-end">
            <a href="{{ route('super_admin.chairpersons.index') }}" class="btn btn-secondary mr-2">Cancel</a>
            <button type="submit" class="btn btn-primary">Update</button>
        </div>
    </form>
</div>
@endsection
