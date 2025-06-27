<div>
    @section('title', 'Admin Dashboard')

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Stats Cards -->
                <x-stats-card title="Total Jumuiyas" :value="$jumuiyas" icon="users" color="blue" />
                <x-stats-card title="Total Members" :value="$members" icon="user-group" color="green" />
                <x-stats-card title="Total Contributions" :value="number_format($contributions)" prefix="TZS " icon="currency-dollar" color="indigo" />
                <x-stats-card title="Upcoming Events" :value="$upcomingEvents" icon="calendar" color="purple" />
            </div>

            <!-- Recent Activities Section -->
            <div class="mt-8 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Recent Activities</h3>
                    <div class="space-y-4">
                        @foreach($recentActivities as $activity)
                            <div class="flex items-start">
                                <div class="flex-shrink-0 bg-{{ $activity['color'] }}-100 p-2 rounded-md">
                                    {{-- <x-icon name="{{ $activity['icon'] }}" class="h-5 w-5 text-{{ $activity['color'] }}-600" /> --}}
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-gray-900">{{ $activity['title'] }}</p>
                                    <p class="text-sm text-gray-500">{{ $activity['description'] }}</p>
                                    <p class="text-xs text-gray-400 mt-1">{{ $activity['time'] }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>