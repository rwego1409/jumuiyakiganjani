@extends('layouts.app')

@section('content')
<div class="container mx-auto py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Admins</h1>
        <a href="{{ route('super_admin.admins.create') }}" class="btn btn-primary">Add Admin</a>
    </div>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <div class="bg-white shadow rounded-lg overflow-x-auto">
        <table class="min-w-full">
            <thead>
                <tr>
                    <th class="px-4 py-2">Name</th>
                    <th class="px-4 py-2">Email</th>
                    <th class="px-4 py-2">Phone</th>
                    <th class="px-4 py-2">Status</th>
                    <th class="px-4 py-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($admins as $admin)
                    <tr>
                        <td class="px-4 py-2">{{ $admin->name }}</td>
                        <td class="px-4 py-2">{{ $admin->email }}</td>
                        <td class="px-4 py-2">{{ $admin->phone }}</td>
                        <td class="px-4 py-2">{{ ucfirst($admin->status ?? 'active') }}</td>
                        <td class="px-4 py-2 space-x-2">
                            <a href="{{ route('super_admin.admins.show', $admin) }}" class="btn btn-sm btn-info">View</a>
                            <a href="{{ route('super_admin.admins.edit', $admin) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('super_admin.admins.destroy', $admin) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-4 py-2 text-center">No admins found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $admins->links() }}</div>
</div>
@endsection
