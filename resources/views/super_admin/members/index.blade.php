@extends('layouts.super_admin')

@section('content')
<div class="max-w-7xl mx-auto px-2 sm:px-4 md:px-6 lg:px-8 py-4 sm:py-8">
    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center mb-4 sm:mb-6 gap-2 sm:gap-0">
        <h1 class="text-xl sm:text-2xl font-bold truncate">Members</h1>
        <a href="{{ route('super_admin.members.create') }}" class="inline-flex items-center justify-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition w-full sm:w-auto">Add Member</a>
    </div>
    @if(session('success'))
        <div class="mb-4 px-4 py-3 bg-green-100 border border-green-400 text-green-700 rounded relative text-xs sm:text-sm" role="alert">{{ session('success') }}</div>
    @endif
    <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 text-xs sm:text-sm">
            <thead class="bg-gray-50 dark:bg-gray-700">
                <tr>
                    <th class="px-2 sm:px-4 py-2 text-left">Name</th>
                    <th class="px-2 sm:px-4 py-2 text-left">Email</th>
                    <th class="px-2 sm:px-4 py-2 text-left">Phone</th>
                    <th class="px-2 sm:px-4 py-2 text-left">Jumuiya</th>
                    <th class="px-2 sm:px-4 py-2 text-left">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($members as $member)
                    <tr>
                        <td class="px-2 sm:px-4 py-2 break-words max-w-[120px] sm:max-w-none">{{ $member->user->name }}</td>
                        <td class="px-2 sm:px-4 py-2 break-words">{{ $member->user->email }}</td>
                        <td class="px-2 sm:px-4 py-2 break-words">{{ $member->user->phone }}</td>
                        <td class="px-2 sm:px-4 py-2 break-words">{{ $member->jumuiya->name ?? '-' }}</td>
                        <td class="px-2 sm:px-4 py-2 flex flex-col sm:flex-row gap-2 sm:space-x-2 w-full sm:w-auto">
                            <a href="{{ route('super_admin.members.show', $member) }}" class="btn btn-sm btn-info w-full sm:w-auto">View</a>
                            <a href="{{ route('super_admin.members.edit', $member) }}" class="btn btn-sm btn-warning w-full sm:w-auto">Edit</a>
                            <form action="{{ route('super_admin.members.destroy', $member) }}" method="POST" class="inline w-full sm:w-auto">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger w-full sm:w-auto" onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-2 sm:px-4 py-2 text-center text-xs sm:text-sm">No members found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $members->links() }}</div>
</div>
@endsection
