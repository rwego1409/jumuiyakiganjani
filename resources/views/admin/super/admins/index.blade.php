@extends('layouts.dashboard')

@section('title', 'Manage Administrators')

@section('content')
<div class="container px-6 mx-auto grid">
    <h2 class="my-6 text-2xl font-semibold text-gray-700">
        Manage Administrators
    </h2>

    <!-- Success Message -->
    @if(session('success'))
    <div class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg" role="alert">
        {{ session('success') }}
    </div>
    @endif

    <!-- Add New Admin Button -->
    <div class="mb-6">
        <a href="{{ route('super_admin.admins.create') }}"
           class="px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
            Add New Administrator
        </a>
    </div>

    <!-- Admin List -->
    <div class="w-full overflow-hidden rounded-lg shadow-xs">
        <div class="w-full overflow-x-auto">
            <table class="w-full whitespace-no-wrap">
                <thead>
                    <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b bg-gray-50">
                        <th class="px-4 py-3">Name</th>
                        <th class="px-4 py-3">Email</th>
                        <th class="px-4 py-3">Phone</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3">Assigned Jumuiyas</th>
                        <th class="px-4 py-3">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y">
                    @foreach($admins as $admin)
                    <tr class="text-gray-700">
                        <td class="px-4 py-3">
                            <div class="flex items-center text-sm">
                                <div>
                                    <p class="font-semibold">{{ $admin->name }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-4 py-3 text-sm">
                            {{ $admin->email }}
                        </td>
                        <td class="px-4 py-3 text-sm">
                            {{ $admin->phone }}
                        </td>
                        <td class="px-4 py-3 text-sm">
                            <span class="px-2 py-1 font-semibold leading-tight rounded-full {{ $admin->status === 'active' ? 'text-green-700 bg-green-100' : 'text-red-700 bg-red-100' }}">
                                {{ ucfirst($admin->status) }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-sm">
                            {{ $admin->managedJumuiyas->count() }}
                        </td>
                        <td class="px-4 py-3 text-sm">
                            <div class="flex items-center space-x-4">
                                <a href="{{ route('super_admin.admins.edit', $admin) }}"
                                   class="text-blue-500 hover:text-blue-600" title="Edit">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </a>
                                <a href="{{ route('super_admin.admins.activities', $admin) }}"
                                   class="text-purple-500 hover:text-purple-600" title="View Activities">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </a>
                                <form action="{{ route('super_admin.admins.destroy', $admin) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this administrator?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-600" title="Delete">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="px-4 py-3 border-t">
            {{ $admins->links() }}
        </div>
    </div>
</div>
@endsection
