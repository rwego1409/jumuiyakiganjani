@extends('layouts.chairperson')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-pink-50 via-white to-purple-100 dark:from-pink-900 dark:via-gray-800 dark:to-purple-900 py-8 sm:py-12">
    <div class="max-w-6xl mx-auto px-2 sm:px-4 lg:px-8">
        <div class="bg-white/80 dark:bg-purple-900/80 backdrop-blur-md shadow-2xl rounded-2xl border border-pink-200/60 dark:border-purple-700/60 p-4 sm:p-8">
            <div class="mb-6 flex flex-col sm:flex-row items-center gap-2 sm:gap-3 justify-between">
                <h2 class="text-xl sm:text-2xl font-bold bg-gradient-to-r from-pink-600 to-purple-600 bg-clip-text text-transparent drop-shadow-lg text-center sm:text-left w-full">
                    Members
                </h2>
                <a href="{{ route('chairperson.members.create') }}" class="mt-2 sm:mt-0 inline-flex items-center px-4 py-2 bg-green-100 text-green-700 border border-green-200 rounded-xl font-semibold text-xs sm:text-sm uppercase tracking-widest shadow hover:bg-green-200 hover:text-green-900 focus:outline-none focus:ring-2 focus:ring-green-400 transition">
                    <i class="fas fa-plus mr-2 text-green-500"></i> Add Member
                </a>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white/80 dark:bg-gray-700/80 backdrop-blur-md rounded-2xl shadow-2xl border border-pink-200/50 dark:border-pink-900/50 p-6">
                    <div class="text-xs md:text-sm font-medium text-pink-700 dark:text-pink-300">Total Members</div>
                    <div class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['total_members'] }}</div>
                </div>

                <div class="bg-white/80 dark:bg-gray-700/80 backdrop-blur-md rounded-2xl shadow-2xl border border-pink-200/50 dark:border-pink-900/50 p-6">
                    <div class="text-xs md:text-sm font-medium text-pink-700 dark:text-pink-300">Active Members</div>
                    <div class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['active_members'] }}</div>
                </div>

                <div class="bg-white/80 dark:bg-gray-700/80 backdrop-blur-md rounded-2xl shadow-2xl border border-pink-200/50 dark:border-pink-900/50 p-6">
                    <div class="text-xs md:text-sm font-medium text-pink-700 dark:text-pink-300">Inactive Members</div>
                    <div class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['inactive_members'] }}</div>
                </div>
            </div>

            <!-- Members List -->
            <div class="mt-4 md:mt-8">
                <div class="flex flex-col">
                    <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                        <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                            <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                                <div class="overflow-x-auto rounded-lg">
                                    <table class="min-w-full divide-y divide-pink-200 dark:divide-purple-700 text-xs sm:text-sm">
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Phone</th>
                                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Joined Date</th>
                                                <th scope="col" class="relative px-6 py-3">
                                                    <span class="sr-only">Actions</span>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-200">
                                            @forelse($members as $member)
                                                <tr>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <div class="text-sm font-medium text-gray-900">
                                                            {{ $member->user->name }}
                                                        </div>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <div class="text-sm text-gray-900">
                                                            {{ $member->user->email }}
                                                        </div>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <div class="text-sm text-gray-900">
                                                            {{ $member->phone }}
                                                        </div>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $member->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                            {{ ucfirst($member->status) }}
                                                        </span>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                        {{ $member->joined_date->format('M d, Y') }}
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                        <a href="{{ route('chairperson.members.show', $member) }}" class="text-indigo-600 hover:text-indigo-900">
                                                            <i class="fas fa-eye text-green-500"></i>
                                                        </a>
                                                        <a href="{{ route('chairperson.members.edit', $member) }}" class="bg-green-100 text-green-700 hover:bg-green-200 hover:text-green-900 px-3 py-1 rounded font-semibold shadow focus:outline-none focus:ring-2 focus:ring-green-400 transition mr-2">
                                                            <i class="fas fa-edit text-green-500"></i>
                                                        </a>
                                                        <form action="{{ route('chairperson.members.destroy', $member) }}" method="POST" class="inline-block">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="bg-green-100 text-green-700 hover:bg-green-200 hover:text-green-900 px-3 py-1 rounded font-semibold shadow focus:outline-none focus:ring-2 focus:ring-green-400 transition">
                                                                <i class="fas fa-trash text-green-500"></i>
                                                            </button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500">
                                                        No members found
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

                <div class="mt-4">
                    {{ $members->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
