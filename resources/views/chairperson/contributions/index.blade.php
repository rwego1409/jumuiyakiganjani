@extends('layouts.chairperson')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-pink-50 via-white to-purple-100 dark:from-pink-900 dark:via-gray-800 dark:to-purple-900 py-8 sm:py-12">
    <div class="max-w-6xl mx-auto px-2 sm:px-4 lg:px-8">
        <div class="bg-white/80 dark:bg-purple-900/80 backdrop-blur-md shadow-2xl rounded-2xl border border-pink-200/60 dark:border-purple-700/60 p-4 sm:p-8">
            <div class="mb-6 flex flex-col sm:flex-row items-center gap-2 sm:gap-3 justify-between">
                <h2 class="text-xl sm:text-2xl font-bold bg-gradient-to-r from-pink-600 to-purple-600 bg-clip-text text-transparent drop-shadow-lg text-center sm:text-left w-full">{{ __('Contributions') }}</h2>
                <a href="{{ route('chairperson.contributions.create') }}" class="mt-2 sm:mt-0 inline-flex items-center px-4 py-2 bg-blue-100 text-blue-700 border border-blue-200 rounded-xl font-semibold text-xs sm:text-sm uppercase tracking-widest shadow hover:bg-blue-200 hover:text-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-400 transition">
                    <i class="fas fa-plus mr-2 text-blue-500"></i> {{ __('Add Contribution') }}
                </a>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white/80 dark:bg-gray-700/80 backdrop-blur-md rounded-2xl shadow-2xl border border-purple-200/50 dark:border-purple-900/50 p-6">
                    <div class="text-xs md:text-sm font-medium text-purple-700 dark:text-purple-300">Total Amount</div>
                    <div class="text-2xl font-bold text-gray-900 dark:text-white">TZS {{ number_format($stats['total_amount']) }}</div>
                </div>
                <div class="bg-white/80 dark:bg-gray-700/80 backdrop-blur-md rounded-2xl shadow-2xl border border-purple-200/50 dark:border-purple-900/50 p-6">
                    <div class="text-xs md:text-sm font-medium text-purple-700 dark:text-purple-300">Total Contributions</div>
                    <div class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['total_contributions'] }}</div>
                </div>
                <div class="bg-white/80 dark:bg-gray-700/80 backdrop-blur-md rounded-2xl shadow-2xl border border-purple-200/50 dark:border-purple-900/50 p-6">
                    <div class="text-xs md:text-sm font-medium text-purple-700 dark:text-purple-300">Pending Contributions</div>
                    <div class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['pending_contributions'] }}</div>
                </div>
            </div>

            <!-- Contributions List -->
            <div class="mt-8">
                <div class="flex flex-col">
                    <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                        <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                            <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                                <div class="overflow-x-auto rounded-lg">
                                    <table class="min-w-full divide-y divide-pink-200 dark:divide-purple-700">
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Member</th>
                                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                                <th scope="col" class="relative px-6 py-3">
                                                    <span class="sr-only">Actions</span>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-200">
                                            @forelse($contributions as $contribution)
                                                <tr>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <div class="text-sm font-medium text-gray-900">
                                                            {{ $contribution->member->user->name }}
                                                        </div>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <div class="text-sm text-gray-900">
                                                            TZS {{ number_format($contribution->amount) }}
                                                        </div>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <div class="text-sm text-gray-900">
                                                            {{ $contribution->contribution_date->format('M d, Y') }}
                                                        </div>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $contribution->status === 'confirmed' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                                            {{ ucfirst($contribution->status) }}
                                                        </span>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                        <a href="{{ route('chairperson.contributions.show', $contribution) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">
                                                            <i class="fas fa-eye text-blue-500"></i>
                                                        </a>
                                                        <a href="{{ route('chairperson.contributions.edit', $contribution) }}" class="bg-blue-100 text-blue-700 hover:bg-blue-200 hover:text-blue-900 px-3 py-1 rounded font-semibold shadow focus:outline-none focus:ring-2 focus:ring-blue-400 transition mr-2">
                                                            <i class="fas fa-edit text-blue-500"></i>
                                                        </a>
                                                        <form action="{{ route('chairperson.contributions.destroy', $contribution) }}" method="POST" class="inline-block">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="bg-blue-100 text-blue-700 hover:bg-blue-200 hover:text-blue-900 px-3 py-1 rounded font-semibold shadow focus:outline-none focus:ring-2 focus:ring-blue-400 transition">
                                                                <i class="fas fa-trash text-blue-500"></i>
                                                            </button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">
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

                <div class="mt-4">
                    {{ $contributions->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
