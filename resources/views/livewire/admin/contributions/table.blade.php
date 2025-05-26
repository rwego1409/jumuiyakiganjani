<div>
    <div class="mb-4">
        <div class="flex items-center justify-between">
            <!-- Search -->
            <div class="flex-1 max-w-sm">
                <input wire:model.live.debounce.300ms="search" type="search" placeholder="Search contributions..." 
                    class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
            </div>

            <!-- Filters -->
            <div class="flex items-center space-x-4 ml-4">
                <select wire:model.live="filters.status" class="block pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                    <option value="">All Status</option>
                    <option value="pending">Pending</option>
                    <option value="confirmed">Confirmed</option>
                    <option value="rejected">Rejected</option>
                </select>

                <select wire:model.live="filters.payment_method" class="block pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                    <option value="">All Methods</option>
                    <option value="mobile">Mobile</option>
                    <option value="cash">Cash</option>
                    <option value="bank">Bank</option>
                </select>

                <input wire:model.live="filters.date_from" type="date" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm border-gray-300 rounded-md">
                <input wire:model.live="filters.date_to" type="date" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm border-gray-300 rounded-md">

                <button wire:click="resetFilters" class="inline-flex items-center px-2.5 py-1.5 border border-gray-300 shadow-sm text-xs font-medium rounded text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Reset
                </button>
            </div>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer" wire:click="sortBy('member_id')">
                        Member
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer" wire:click="sortBy('jumuiya_id')">
                        Jumuiya
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer" wire:click="sortBy('amount')">
                        Amount
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer" wire:click="sortBy('contribution_date')">
                        Date
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Payment Method
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Status
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Actions
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($contributions as $contribution)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            {{ $contribution->member->user->name }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            {{ $contribution->jumuiya->name }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            TZS {{ number_format($contribution->amount) }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            {{ $contribution->contribution_date->format('M d, Y') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            {{ ucfirst($contribution->payment_method) }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                {{ $contribution->status === 'confirmed' ? 'bg-green-100 text-green-800' : '' }}
                                {{ $contribution->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                {{ $contribution->status === 'rejected' ? 'bg-red-100 text-red-800' : '' }}">
                                {{ ucfirst($contribution->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <a href="{{ route('admin.contributions.show', $contribution) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">View</a>
                            <a href="{{ route('admin.contributions.edit', $contribution) }}" class="text-green-600 hover:text-green-900">Edit</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                            No contributions found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $contributions->links() }}
    </div>
</div>
