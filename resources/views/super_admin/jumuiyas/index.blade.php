@extends('layouts.app')

@section('content')
<div class="container mx-auto py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Jumuiyas</h1>
        <a href="{{ route('super_admin.jumuiyas.create') }}" class="btn btn-primary">Add Jumuiya</a>
    </div>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <div class="bg-white shadow rounded-lg overflow-x-auto">
        <table class="min-w-full">
            <thead>
                <tr>
                    <th class="px-4 py-2">Name</th>
                    <th class="px-4 py-2">Location</th>
                    <th class="px-4 py-2">Chairperson</th>
                    <th class="px-4 py-2">Created</th>
                    <th class="px-4 py-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($jumuiyas as $jumuiya)
                    <tr>
                        <td class="px-4 py-2">{{ $jumuiya->name }}</td>
                        <td class="px-4 py-2">{{ $jumuiya->location ?? '-' }}</td>
                        <td class="px-4 py-2">{{ $jumuiya->chairperson->name ?? '-' }}</td>
                        <td class="px-4 py-2">{{ $jumuiya->created_at->diffForHumans() }}</td>
                        <td class="px-4 py-2 space-x-2">
                            <a href="#" class="btn btn-sm btn-info">View</a>
                            <a href="#" class="btn btn-sm btn-warning">Edit</a>
                            <form action="#" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-4 py-2 text-center">No jumuiyas found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $jumuiyas->links() }}</div>
</div>
@endsection
