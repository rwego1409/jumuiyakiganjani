<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Super Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Stats Overview -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <!-- Total Jumuiyas -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="text-gray-500 text-sm mb-1">Total Jumuiyas</div>
                        <div class="text-3xl font-bold text-gray-800">{{ $totalJumuiyas }}</div>
                    </div>
                </div>

                <!-- Total Chairpersons -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="text-gray-500 text-sm mb-1">Total Chairpersons</div>
                        <div class="text-3xl font-bold text-gray-800">{{ $totalChairpersons }}</div>
                    </div>
                </div>

                <!-- Total Members -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="text-gray-500 text-sm mb-1">Total Members</div>
                        <div class="text-3xl font-bold text-gray-800">{{ $totalMembers }}</div>
                    </div>
                </div>
            </div>

            <!-- Recent Jumuiyas -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-medium text-gray-900">Recent Jumuiyas</h3>
                        <a href="{{ route('super_admin.jumuiyas.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Create New Jumuiya
                        </a>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead>
                                <tr>
                                    <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                    <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Location</th>
                                    <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Chairperson</th>
                                    <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Created</th>
                                    <th class="px-6 py-3 bg-gray-50 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($recentJumuiyas as $jumuiya)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $jumuiya->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $jumuiya->location }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{ $jumuiya->chairperson->name ?? 'No Chairperson' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $jumuiya->created_at->diffForHumans() }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <a href="{{ route('super_admin.jumuiyas.edit', $jumuiya) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        <a href="{{ route('super_admin.jumuiyas.index') }}" class="text-blue-600 hover:text-blue-800">View All Jumuiyas →</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
