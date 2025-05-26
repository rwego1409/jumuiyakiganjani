@extends('layouts.dashboard')

@section('title', 'Create Administrator')

@section('content')
<div class="container px-6 mx-auto grid">
    <h2 class="my-6 text-2xl font-semibold text-gray-700">
        Create New Administrator
    </h2>

    <div class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md">
        <form action="{{ route('super_admin.admins.store') }}" method="POST">
            @csrf

            <div class="mb-4">
                <label class="block text-sm">
                    <span class="text-gray-700">Name</span>
                    <input type="text" name="name" value="{{ old('name') }}" required
                           class="block w-full mt-1 text-sm focus:border-purple-400 focus:outline-none focus:shadow-outline-purple form-input
                           @error('name') border-red-500 @enderror">
                </label>
                @error('name')
                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-sm">
                    <span class="text-gray-700">Email</span>
                    <input type="email" name="email" value="{{ old('email') }}" required
                           class="block w-full mt-1 text-sm focus:border-purple-400 focus:outline-none focus:shadow-outline-purple form-input
                           @error('email') border-red-500 @enderror">
                </label>
                @error('email')
                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-sm">
                    <span class="text-gray-700">Phone</span>
                    <input type="text" name="phone" value="{{ old('phone') }}" required
                           class="block w-full mt-1 text-sm focus:border-purple-400 focus:outline-none focus:shadow-outline-purple form-input
                           @error('phone') border-red-500 @enderror">
                </label>
                @error('phone')
                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-sm">
                    <span class="text-gray-700">Password</span>
                    <input type="password" name="password" required
                           class="block w-full mt-1 text-sm focus:border-purple-400 focus:outline-none focus:shadow-outline-purple form-input
                           @error('password') border-red-500 @enderror">
                </label>
                @error('password')
                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-sm">
                    <span class="text-gray-700">Confirm Password</span>
                    <input type="password" name="password_confirmation" required
                           class="block w-full mt-1 text-sm focus:border-purple-400 focus:outline-none focus:shadow-outline-purple form-input">
                </label>
            </div>

            <div class="mb-4">
                <label class="block text-sm">
                    <span class="text-gray-700">Assign Jumuiyas</span>
                    <select name="assigned_jumuiyas[]" multiple
                            class="block w-full mt-1 text-sm focus:border-purple-400 focus:outline-none focus:shadow-outline-purple form-multiselect">
                        @foreach($jumuiyas as $jumuiya)
                        <option value="{{ $jumuiya->id }}" {{ in_array($jumuiya->id, old('assigned_jumuiyas', [])) ? 'selected' : '' }}>
                            {{ $jumuiya->name }}
                        </option>
                        @endforeach
                    </select>
                </label>
                @error('assigned_jumuiyas')
                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mt-6">
                <button type="submit"
                        class="px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
                    Create Administrator
                </button>
                <a href="{{ route('super_admin.admins.index') }}"
                   class="px-4 py-2 text-sm font-medium leading-5 text-gray-700 transition-colors duration-150 border border-gray-300 rounded-lg active:bg-transparent hover:border-gray-500 focus:border-gray-500 active:text-gray-500 focus:outline-none focus:shadow-outline-gray">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
