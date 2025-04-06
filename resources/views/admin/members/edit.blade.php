@extends('layouts.admin')

@section('content')
    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-3xl font-bold text-gray-900">Edit Member</h1>

            <form method="POST" action="{{ route('admin.members.update', $member->id) }}">
                @csrf
                @method('PUT')

                <div class="mt-4">
                    <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $member->user->name) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                </div>

                <div class="mt-4">
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email', $member->user->email) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                </div>

                <div class="mt-4">
                    <label for="jumuiya_id" class="block text-sm font-medium text-gray-700">Jumuiya</label>
                    <select name="jumuiya_id" id="jumuiya_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                        @foreach($jumuiyas as $jumuiya)
                            <option value="{{ $jumuiya->id }}" {{ $jumuiya->id == old('jumuiya_id', $member->jumuiya_id) ? 'selected' : '' }}>{{ $jumuiya->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mt-4">
                    <label for="phone" class="block text-sm font-medium text-gray-700">Phone</label>
                    <input type="text" name="phone" id="phone" value="{{ old('phone', $member->phone) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                </div>

                <div class="mt-4">
                    <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Update Member
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
