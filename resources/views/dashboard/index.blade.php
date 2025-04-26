@php
    $user = auth()->user();
    $role = $user->role;
    if (!in_array($role, ['admin', 'member'])) {
        abort(403, 'Unauthorized role');
    }
@endphp

@extends($role === 'admin' ? 'layouts.admin' : 'layouts.member')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="py-4">
            <h2 class="text-2xl font-semibold text-gray-900 dark:text-gray-100">
                {{ $role === 'admin' ? 'Admin Dashboard' : 'Member Dashboard' }}
            </h2>
        </div>

        <div class="space-y-6">
            @include("dashboard.partials.{$role}-stats")
        </div>
    </div>
@endsection
