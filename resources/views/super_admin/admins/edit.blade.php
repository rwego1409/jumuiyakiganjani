@extends('layouts.app')

@section('content')
<div class="container mx-auto py-8 max-w-lg">
    <h1 class="text-2xl font-bold mb-6">Edit Admin</h1>
    <form method="POST" action="{{ route('super_admin.admins.update', $admin) }}">
        @csrf
        @method('PUT')
        <div class="mb-4">
            <label class="block mb-1">Name</label>
            <input type="text" name="name" class="form-input w-full" value="{{ old('name', $admin->name) }}" required>
            @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>
        <div class="mb-4">
            <label class="block mb-1">Email</label>
            <input type="email" name="email" class="form-input w-full" value="{{ old('email', $admin->email) }}" required>
            @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>
        <div class="mb-4">
            <label class="block mb-1">Phone</label>
            <input type="text" name="phone" class="form-input w-full" value="{{ old('phone', $admin->phone) }}" required>
            @error('phone') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>
        <div class="mb-4">
            <label class="block mb-1">Password <span class="text-xs text-gray-400">(leave blank to keep current)</span></label>
            <input type="password" name="password" class="form-input w-full">
            @error('password') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>
        <div class="mb-4">
            <label class="block mb-1">Assign Jumuiyas</label>
            <select name="assigned_jumuiyas[]" class="form-input w-full" multiple>
                @foreach($jumuiyas as $jumuiya)
                    <option value="{{ $jumuiya->id }}" {{ in_array($jumuiya->id, $assignedJumuiyas ?? []) ? 'selected' : '' }}>{{ $jumuiya->name }}</option>
                @endforeach
            </select>
            @error('assigned_jumuiyas') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>
        <div class="mb-4">
            <label class="block mb-1">Status</label>
            <select name="status" class="form-input w-full">
                <option value="active" {{ old('status', $admin->status ?? 'active') == 'active' ? 'selected' : '' }}>Active</option>
                <option value="inactive" {{ old('status', $admin->status ?? 'active') == 'inactive' ? 'selected' : '' }}>Inactive</option>
            </select>
            @error('status') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>
        <div class="flex justify-end">
            <button type="submit" class="btn btn-primary">Update Admin</button>
        </div>
    </form>
</div>
@endsection
