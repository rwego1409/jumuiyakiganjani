@extends('layouts.guest')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex items-start">
            <div class="flex-shrink-0 text-{{ $notification->type }}-500">
                <i class="{{ $notification->data['icon'] ?? 'fas fa-bell' }} text-3xl"></i>
            </div>
            <div class="ml-4">
                <h1 class="text-xl font-bold">{{ $notification->message }}</h1>
                <p class="text-gray-500 mt-1">{{ $notification->created_at->format('M j, Y \a\t g:i a') }}</p>
                
                @if(isset($notification->data['details']))
                    <div class="mt-4 p-4 bg-gray-50 rounded-lg">
                        <p class="text-gray-700">{{ $notification->data['details'] }}</p>
                    </div>
                @endif
                
                <div class="mt-6">
                    <a href="{{ url()->previous() }}" class="text-primary-600 hover:text-primary-800">
                        &larr; Back to notifications
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection