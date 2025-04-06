@extends('layouts.admin')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-semibold">Events Management</h2>
                    <a href="{{ route('admin.events.create') }}" class="btn-primary">
                        Create New Event
                    </a>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($events as $event)
                    <div class="bg-white rounded-lg shadow-sm border border-gray-100">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold mb-2">{{ $event->title }}</h3>
                            <div class="text-sm text-gray-600 mb-2">
                                <span class="font-medium">Date:</span> 
                                {{ \Carbon\Carbon::parse($event->start_time)->format('M d, Y h:i A') }}
                            </div>
                            <div class="text-sm text-gray-600 mb-4">
                                {{ Str::limit($event->description, 100) }}
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="px-2 py-1 text-xs font-medium rounded-full 
                                    {{ $event->status === 'upcoming' ? 'bg-blue-100 text-blue-800' : ($event->status === 'ongoing' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800') }}">
                                    {{ ucfirst($event->status) }}
                                </span>
                                <div class="space-x-2">
                                    <a href="{{ route('admin.events.edit', $event->id) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                    <form class="inline-block" action="{{ route('admin.events.destroy', $event->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-4">
                    @if($events->isEmpty())
                        <div class="text-center text-gray-600">
                            No events available.
                        </div>
                    @else
                        {{ $events->links() }}
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection