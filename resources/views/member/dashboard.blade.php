@extends('layouts.member')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Welcome Header -->
        <div class="pb-5 border-b border-gray-200">
            <h1 class="text-3xl font-bold text-gray-900">
                Welcome, {{ Auth::user()->name }}
            </h1>

            @if($member && $member->jumuiya)
    <p class="mt-2 text-sm text-gray-600">
        Member of {{ $member->jumuiya->name }} Jumuiya
        @if($community_data['jumuiya_rank'])
            (Rank #{{ $community_data['jumuiya_rank'] }} in contributions)
        @endif
    </p>
@else
    <!-- Profile completion warning -->
@endif
        </div>

        @if($member)
            <!-- Stats Grid - Updated for new structure -->
            <div class="mt-6 grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4">
                <!-- Personal Contributions Card -->
                <div class="bg-white overflow-hidden shadow rounded-lg">
                    <div class="px-4 py-5 sm:p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-indigo-500 rounded-md p-3">
                                <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dt class="text-sm font-medium text-gray-500 truncate">
                                    Your Contributions
                                </dt>
                                <dd class="flex items-baseline">
                                    <div class="text-2xl font-semibold text-gray-900">
                                        TZS {{ number_format($stats['total_contributions']) }}
                                    </div>
                                    @if($stats['contribution_increase'] != 0)
                                        <span class="ml-2 text-sm font-semibold {{ $stats['contribution_increase'] > 0 ? 'text-green-600' : 'text-red-600' }}">
                                            {{ $stats['contribution_increase'] > 0 ? '+' : '' }}{{ $stats['contribution_increase'] }}%
                                        </span>
                                    @endif
                                </dd>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Community Contributions Card -->
                <div class="bg-white overflow-hidden shadow rounded-lg">
                    <div class="px-4 py-5 sm:p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-green-500 rounded-md p-3">
                                <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dt class="text-sm font-medium text-gray-500 truncate">
                                    Community Total
                                </dt>
                                <dd class="text-2xl font-semibold text-gray-900">
                                    TZS {{ number_format($community_data['total_community_contributions']) }}
                                </dd>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Member Since Card -->
                <div class="bg-white overflow-hidden shadow rounded-lg">
                    <div class="px-4 py-5 sm:p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-blue-500 rounded-md p-3">
                                <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dt class="text-sm font-medium text-gray-500 truncate">
                                    Member Since
                                </dt>
                                <dd class="text-2xl font-semibold text-gray-900">
                                    {{ $stats['member_since'] }}
                                </dd>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Jumuiya Members Card -->
                <div class="bg-white overflow-hidden shadow rounded-lg">
                    <div class="px-4 py-5 sm:p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-purple-500 rounded-md p-3">
                                <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dt class="text-sm font-medium text-gray-500 truncate">
                                    Total Members
                                </dt>
                                <dd class="text-2xl font-semibold text-gray-900">
                                    {{ number_format($community_data['total_members']) }}
                                </dd>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Upcoming Events Section -->
            <div class="mt-6">
                <div class="flex justify-between items-center">
                    <h2 class="text-lg leading-6 font-medium text-gray-900">Upcoming Events</h2>
                    @if($jumuiya)
                        <span class="text-sm text-gray-500">Showing events for {{ $jumuiya->name }} and community-wide events</span>
                    @endif
                </div>
                <div class="mt-4 grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
                    @forelse($upcoming_events as $event)
                        <div class="bg-white overflow-hidden shadow rounded-lg">
                            <div class="px-4 py-5 sm:p-6">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 {{ $event->jumuiya_id ? 'bg-blue-500' : 'bg-gray-500' }} rounded-md p-3">
                                        <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                    <div class="ml-4">
                                        <h3 class="text-lg font-medium text-gray-900">{{ $event->title }}</h3>
                                        <p class="mt-1 text-sm text-gray-500">
                                            {{ $event->start_time->format('M d, Y h:i A') }}
                                            @if($event->jumuiya)
                                                <br>For {{ $event->jumuiya->name }}
                                            @else
                                                <br>Community Event
                                            @endif
                                        </p>
                                    </div>
                                </div>
                                <p class="mt-4 text-sm text-gray-500">
                                    {{ Str::limit($event->description, 100) }}
                                </p>
                            </div>
                        </div>
                    @empty
                        <p class="text-sm text-gray-500">No upcoming events</p>
                    @endforelse
                </div>
            </div>

            <!-- Recent Resources Section -->
            <div class="mt-6">
                <h2 class="text-lg leading-6 font-medium text-gray-900">Recent Resources</h2>
                <div class="mt-4 grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
                    @forelse($recent_resources as $resource)
                        <div class="bg-white overflow-hidden shadow rounded-lg">
                            <div class="px-4 py-5 sm:p-6">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 bg-indigo-500 rounded-md p-3">
                                        <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                    </div>
                                    <div class="ml-4">
                                        <h3 class="text-lg font-medium text-gray-900">{{ $resource->title }}</h3>
                                        <p class="mt-1 text-sm text-gray-500">
                                            Uploaded {{ $resource->created_at->diffForHumans() }}
                                        </p>
                                    </div>
                                </div>
                                <div class="mt-4">
                                    <a href="{{ route('resources.download', $resource->id) }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-500">
                                        Download Resource
                                    </a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="text-sm text-gray-500">No resources available</p>
                    @endforelse
                </div>
            </div>

            <!-- Recent Contributions Section -->
            <div class="mt-6">
                <h2 class="text-lg leading-6 font-medium text-gray-900">Your Recent Contributions</h2>
                <div class="mt-4">
                    <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                        <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                            <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Date
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Amount
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Purpose
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Jumuiya
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @forelse($recent_contributions as $contribution)
                                            <tr>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    {{ $contribution->contribution_date->format('M d, Y') }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                    TZS {{ number_format($contribution->amount) }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    {{ $contribution->purpose ?? 'General Contribution' }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    {{ $contribution->jumuiya->name ?? 'Community' }}
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="px-6 py-4 text-center text-sm text-gray-500">
                                                    No contributions found
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <!-- Profile completion warning (existing code) -->
        @endif
    </div>
</div>
@endsection