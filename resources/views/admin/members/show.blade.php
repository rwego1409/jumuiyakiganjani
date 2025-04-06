@extends('layouts.admin')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-2xl font-semibold">Member Details</h2>
                    <div class="space-x-4">
                        <a href="{{ route('admin.members.edit', $member->id) }}" class="btn-primary">
                            Edit Member
                        </a>
                        <a href="{{ route('admin.members.index') }}" class="btn-secondary">
                            Back to List
                        </a>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Personal Information -->
                    <div class="bg-gray-50 p-6 rounded-lg">
                        <h3 class="text-lg font-medium mb-4">Personal Information</h3>
                        <dl class="space-y-4">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Full Name</dt>
                                <dd class="mt-1 text-gray-900">{{ $member->user->name }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Email</dt>
                                <dd class="mt-1 text-gray-900">{{ $member->user->email }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Phone</dt>
                                <dd class="mt-1 text-gray-900">{{ $member->phone }}</dd>
                            </div>
                        </dl>
                    </div>

                    <!-- Membership Details -->
                    <div class="bg-gray-50 p-6 rounded-lg">
                        <h3 class="text-lg font-medium mb-4">Membership Details</h3>
                        <dl class="space-y-4">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Jumuiya</dt>
                                <dd class="mt-1 text-gray-900">{{ $member->jumuiya->name }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Status</dt>
                                <dd class="mt-1">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        {{ $member->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ ucfirst($member->status) }}
                                    </span>
                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Joined Date</dt>
                                <dd class="mt-1 text-gray-900">{{ $member->joined_date->format('M d, Y') }}</dd>
                            </div>
                        </dl>
                    </div>
                </div>

                <!-- Contributions Section -->
                <div class="mt-8">
                    <h3 class="text-lg font-medium mb-4">Recent Contributions</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <!-- Table structure similar to dashboard -->
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection