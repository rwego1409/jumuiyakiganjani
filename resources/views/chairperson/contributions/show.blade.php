@extends('layouts.chairperson')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-pink-50 via-white to-purple-100 dark:from-pink-900 dark:via-gray-800 dark:to-purple-900 py-8 sm:py-12">
    <div class="max-w-7xl mx-auto px-2 sm:px-4 lg:px-8">
        <!-- Page Header -->
        <div class="mb-8">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Contributions Management</h1>
                    <p class="text-gray-600 dark:text-gray-300">Manage member contributions and view cashbook</p>
                </div>
                <div class="flex space-x-3">
                    <a href="{{ route('chairperson.contributions.create') }}" class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-lg font-semibold shadow hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-400 transition">
                        <i class="fas fa-plus mr-2"></i> Add Contribution
                    </a>
                </div>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-2 bg-green-100 rounded-lg">
                        <i class="fas fa-coins text-green-600 text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Total Amount</p>
                        <p class="text-lg font-bold text-gray-900">TZS {{ number_format($stats['total_amount'], 2) }}</p>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-2 bg-blue-100 rounded-lg">
                        <i class="fas fa-list text-blue-600 text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Total Contributions</p>
                        <p class="text-lg font-bold text-gray-900">{{ $stats['total_contributions'] }}</p>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-2 bg-yellow-100 rounded-lg">
                        <i class="fas fa-clock text-yellow-600 text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Pending</p>
                        <p class="text-lg font-bold text-gray-900">{{ $stats['pending_contributions'] }}</p>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-2 bg-purple-100 rounded-lg">
                        <i class="fas fa-wallet text-purple-600 text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Cash in Hand</p>
                        <p class="text-lg font-bold text-gray-900">TZS {{ number_format($cashInHand, 2) }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filters -->
        <div class="bg-white rounded-lg shadow p-6 mb-8">
            <form method="GET" action="{{ route('chairperson.contributions.index') }}" class="grid grid-cols-1 md:grid-cols-6 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Member</label>
                    <select name="member_id" class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200">
                        <option value="">All Members</option>
                        @foreach($members as $member)
                            <option value="{{ $member->id }}" {{ request('member_id') == $member->id ? 'selected' : '' }}>
                                {{ $member->user->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                    <select name="status" class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200">
                        <option value="">All Status</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                        <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Payment Method</label>
                    <select name="payment_method" class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200">
                        <option value="">All Methods</option>
                        <option value="cash" {{ request('payment_method') == 'cash' ? 'selected' : '' }}>Cash</option>
                        <option value="mobile" {{ request('payment_method') == 'mobile' ? 'selected' : '' }}>Mobile</option>
                        <option value="bank" {{ request('payment_method') == 'bank' ? 'selected' : '' }}>Bank</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Date From</label>
                    <input type="date" name="date_from" value="{{ request('date_from') }}" class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Date To</label>
                    <input type="date" name="date_to" value="{{ request('date_to') }}" class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200">
                </div>
                <div class="flex items-end space-x-2">
                    <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        <i class="fas fa-search mr-1"></i> Filter
                    </button>
                    <a href="{{ route('chairperson.contributions.index') }}" class="px-4 py-2 bg-gray-600 text-white rounded-md shadow-sm hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500">
                        <i class="fas fa-times mr-1"></i> Clear
                    </a>
                </div>
            </form>
        </div>

        <!-- CRUD Table -->
        <div class="bg-white rounded-lg shadow overflow-hidden mb-8">
            <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                <h3 class="text-lg font-medium text-gray-900">All Contributions</h3>
                <div class="flex space-x-2">
                    <button onclick="toggleView('table')" id="tableViewBtn" class="px-3 py-1 bg-indigo-600 text-white rounded text-sm">
                        <i class="fas fa-table mr-1"></i> Table View
                    </button>
                    <button onclick="toggleView('cashbook')" id="cashbookViewBtn" class="px-3 py-1 bg-gray-600 text-white rounded text-sm">
                        <i class="fas fa-book mr-1"></i> Cashbook View
                    </button>
                </div>
            </div>
            
            <!-- Table View -->
            <div id="tableView" class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Member</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Payment Method</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Purpose</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($contributionsForCrud as $contribution)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-8 w-8">
                                        <div class="h-8 w-8 rounded-full bg-indigo-100 flex items-center justify-center">
                                            <span class="text-indigo-600 font-medium text-sm">
                                                {{ substr($contribution->member->user->name, 0, 1) }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-gray-900">{{ $contribution->member->user->name }}</p>
                                        <p class="text-sm text-gray-500">{{ $contribution->member->user->email }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="text-sm font-medium text-gray-900">TZS {{ number_format($contribution->amount, 2) }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $contribution->contribution_date->format('d M Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex px-2 py-1 text-xs font-medium rounded-full
                                    {{ $contribution->payment_method === 'cash' ? 'bg-green-100 text-green-800' : '' }}
                                    {{ $contribution->payment_method === 'mobile' ? 'bg-blue-100 text-blue-800' : '' }}
                                    {{ $contribution->payment_method === 'bank' ? 'bg-purple-100 text-purple-800' : '' }}">
                                    {{ ucfirst($contribution->payment_method) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex px-2 py-1 text-xs font-medium rounded-full
                                    {{ $contribution->status === 'confirmed' ? 'bg-green-100 text-green-800' : '' }}
                                    {{ $contribution->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                    {{ $contribution->status === 'rejected' ? 'bg-red-100 text-red-800' : '' }}">
                                    {{ ucfirst($contribution->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $contribution->purpose ?? 'N/A' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex space-x-2">
                                    <a href="{{ route('chairperson.contributions.show', $contribution) }}" 
                                       class="text-indigo-600 hover:text-indigo-900 p-1 rounded" title="View">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('chairperson.contributions.edit', $contribution) }}" 
                                       class="text-green-600 hover:text-green-900 p-1 rounded" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form method="POST" action="{{ route('chairperson.contributions.destroy', $contribution) }}" 
                                          class="inline" onsubmit="return confirm('Are you sure you want to delete this contribution?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900 p-1 rounded" title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center text-gray-500">
                                <div class="flex flex-col items-center">
                                    <i class="fas fa-inbox text-gray-300 text-4xl mb-4"></i>
                                    <p class="text-lg font-medium">No contributions found</p>
                                    <p class="text-sm">Start by adding your first contribution</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                
                <!-- Pagination -->
                <div class="px-6 py-4 border-t border-gray-200">
                    {{ $contributionsForCrud->withQueryString()->links() }}
                </div>
            </div>
        </div>

        <!-- Cashbook View (Hidden by default) -->
        <div id="cashbookView" class="hidden">
            <!-- Cashbook Header -->
            <div class="bg-gradient-to-r from-orange-400 to-orange-600 rounded-lg p-6 mb-8 text-white flex flex-col md:flex-row justify-between items-center">
                <div>
                    <h3 class="text-lg font-medium opacity-90">Company Name - {{ config('app.name') }}</h3>
                    <h2 class="text-2xl font-bold">Cash Book</h2>
                </div>
                <div class="text-right mt-4 md:mt-0">
                    <p class="text-sm opacity-90">Cash in Hand</p>
                    <p class="text-3xl font-bold">TZS {{ number_format($cashInHand, 2) }}</p>
                </div>
            </div>

            <!-- Cashbook Table -->
            <div class="bg-white rounded-lg shadow overflow-hidden mb-8">
                <div class="grid grid-cols-1 md:grid-cols-2">
                    <!-- Inward Payments -->
                    <div class="border-r border-gray-200">
                        <div class="bg-orange-500 text-white px-6 py-4">
                            <h3 class="font-semibold text-center">Inward Payments</h3>
                        </div>
                        <div class="p-4">
                            <div class="grid grid-cols-3 gap-4 mb-2 text-sm font-medium text-gray-700 border-b pb-2">
                                <div>Date</div>
                                <div>Particular</div>
                                <div>Amount</div>
                            </div>
                            @forelse($allContributions as $contribution)
                            <div class="grid grid-cols-3 gap-4 py-2 text-sm border-b border-gray-100">
                                <div>{{ $contribution->contribution_date->format('d-m-Y') }}</div>
                                <div>{{ $contribution->member->user->name }}</div>
                                <div class="font-medium">TZS {{ number_format($contribution->amount, 2) }}</div>
                            </div>
                            @empty
                            <div class="py-4 text-center text-gray-400 col-span-3">No inward payments</div>
                            @endforelse
                        </div>
                        <div class="bg-orange-500 text-white px-6 py-4">
                            <div class="flex justify-between items-center font-semibold">
                                <span>Inward Total</span>
                                <span>TZS {{ number_format($totalInward, 2) }}</span>
                            </div>
                        </div>
                    </div>
                    <!-- Outward Payments -->
                    <div>
                        <div class="bg-orange-500 text-white px-6 py-4">
                            <h3 class="font-semibold text-center">Outward Payments</h3>
                        </div>
                        <div class="p-4">
                            <div class="grid grid-cols-3 gap-4 mb-2 text-sm font-medium text-gray-700 border-b pb-2">
                                <div>Date</div>
                                <div>Particular</div>
                                <div>Amount</div>
                            </div>
                            @forelse($expenses as $expense)
                            <div class="grid grid-cols-3 gap-4 py-2 text-sm border-b border-gray-100">
                                <div>{{ $expense->date->format('d-m-Y') }}</div>
                                <div>{{ $expense->description }}</div>
                                <div class="font-medium">TZS {{ number_format($expense->amount, 2) }}</div>
                            </div>
                            @empty
                            <div class="py-4 text-center text-gray-400 col-span-3">No outward payments</div>
                            @endforelse
                        </div>
                        <div class="bg-orange-500 text-white px-6 py-4">
                            <div class="flex justify-between items-center font-semibold">
                                <span>Outward Total</span>
                                <span>TZS {{ number_format($totalOutward, 2) }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Member Summary -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Member Contributions Summary</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Member</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Contributed</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Contributions Count</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Last Contribution</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($memberSummary as $summary)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-8 w-8">
                                        <div class="h-8 w-8 rounded-full bg-indigo-100 flex items-center justify-center">
                                            <span class="text-indigo-600 font-medium text-sm">
                                                {{ substr($summary['member']->user->name, 0, 1) }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-gray-900">{{ $summary['member']->user->name }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                TZS {{ number_format($summary['total_amount'], 2) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $summary['contribution_count'] }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $summary['last_contribution']->contribution_date->format('d M Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex space-x-1">
                                    @if($summary['confirmed_amount'] > 0)
                                        <span class="inline-flex px-2 py-1 text-xs font-medium rounded-full bg-green-100 text-green-800">
                                            Confirmed: TZS {{ number_format($summary['confirmed_amount'], 0) }}
                                        </span>
                                    @endif
                                    @if($summary['pending_amount'] > 0)
                                        <span class="inline-flex px-2 py-1 text-xs font-medium rounded-full bg-yellow-100 text-yellow-800">
                                            Pending: TZS {{ number_format($summary['pending_amount'], 0) }}
                                        </span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
function toggleView(view) {
    const tableView = document.getElementById('tableView');
    const cashbookView = document.getElementById('cashbookView');
    const tableBtn = document.getElementById('tableViewBtn');
    const cashbookBtn = document.getElementById('cashbookViewBtn');
    
    if (view === 'table') {
        tableView.classList.remove('hidden');
        cashbookView.classList.add('hidden');
        tableBtn.classList.remove('bg-gray-600');
        tableBtn.classList.add('bg-indigo-600');
        cashbookBtn.classList.remove('bg-indigo-600');
        cashbookBtn.classList.add('bg-gray-600');
    } else if (view === 'cashbook') {
        tableView.classList.add('hidden');
        cashbookView.classList.remove('hidden');
        cashbookBtn.classList.remove('bg-gray-600');
        cashbookBtn.classList.add('bg-indigo-600');
        tableBtn.classList.remove('bg-indigo-600');
        tableBtn.classList.add('bg-gray-600');
    }
}

// Initialize table view as active
document.addEventListener('DOMContentLoaded', function() {
    toggleView('table');
});
</script>
@endsection