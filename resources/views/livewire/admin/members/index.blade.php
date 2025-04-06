<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manage Members') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-medium">All Members</h3>
                        <x-button wire:click="createMember" class="bg-indigo-600 hover:bg-indigo-700">
                            Add New Member
                        </x-button>
                    </div>

                    <!-- Search and Filters -->
                    <div class="mb-6">
                        <div class="flex flex-col md:flex-row md:items-center md:space-x-4 space-y-4 md:space-y-0">
                            <div class="w-full md:w-1/3">
                                <x-input wire:model.debounce.500ms="search" placeholder="Search members..." class="w-full" />
                            </div>
                            <div class="w-full md:w-1/3">
                                <x-select wire:model="jumuiyaFilter" class="w-full">
                                    <option value="">All Jumuiyas</option>
                                    @foreach($jumuiyas as $jumuiya)
                                        <option value="{{ $jumuiya->id }}">{{ $jumuiya->name }}</option>
                                    @endforeach
                                </x-select>
                            </div>
                            <div class="w-full md:w-1/3">
                                <x-select wire:model="statusFilter" class="w-full">
                                    <option value="">All Statuses</option>
                                    <option value="active">Active</option>
                                    <option value="inactive">Inactive</option>
                                </x-select>
                            </div>
                        </div>
                    </div>

                    <!-- Members Table -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        <x-sortable-header wire:click="sortBy('name')" :direction="$sortField === 'name' ? $sortDirection : null">
                                            Name
                                        </x-sortable-header>
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Jumuiya
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        <x-sortable-header wire:click="sortBy('phone')" :direction="$sortField === 'phone' ? $sortDirection : null">
                                            Phone
                                        </x-sortable-header>
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
                                @forelse($members as $member)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-10 w-10">
                                                    <img class="h-10 w-10 rounded-full" src="{{ $member->user->profile_photo_url }}" alt="">
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-medium text-gray-900">{{ $member->user->name }}</div>
                                                    <div class="text-sm text-gray-500">{{ $member->user->email }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">{{ $member->jumuiya->name }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $member->phone }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $member->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                {{ ucfirst($member->status) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <x-button wire:click="editMember({{ $member->id }})" class="text-indigo-600 hover:text-indigo-900 mr-2">
                                                Edit
                                            </x-button>
                                            <x-button wire:click="confirmDelete({{ $member->id }})" class="text-red-600 hover:text-red-900">
                                                Delete
                                            </x-button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                                            No members found
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="mt-6">
                        {{ $members->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Create/Edit Modal -->
    <x-dialog-modal wire:model="showModal">
        <x-slot name="title">
            {{ $editMode ? 'Edit Member' : 'Create New Member' }}
        </x-slot>

        <x-slot name="content">
            <div class="space-y-4">
                <x-input wire:model="form.name" label="Full Name" />
                <x-input wire:model="form.email" type="email" label="Email" />
                <x-input wire:model="form.phone" label="Phone Number" />
                <x-select wire:model="form.jumuiya_id" label="Jumuiya">
                    <option value="">Select Jumuiya</option>
                    @foreach($jumuiyas as $jumuiya)
                        <option value="{{ $jumuiya->id }}">{{ $jumuiya->name }}</option>
                    @endforeach
                </x-select>
                <x-select wire:model="form.status" label="Status">
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                </x-select>
                <x-input wire:model="form.joined_date" type="date" label="Joined Date" />
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-button wire:click="$toggle('showModal')" class="mr-3">Cancel</x-button>
            <x-button wire:click="save" mode="primary">
                {{ $editMode ? 'Update' : 'Create' }}
            </x-button>
        </x-slot>
    </x-dialog-modal>

    <!-- Delete Confirmation Modal -->
    <x-confirmation-modal wire:model="showDeleteModal">
        <x-slot name="title">
            Delete Member
        </x-slot>

        <x-slot name="content">
            Are you sure you want to delete this member? This action cannot be undone.
        </x-slot>

        <x-slot name="footer">
            <x-button wire:click="$toggle('showDeleteModal')">Cancel</x-button>
            <x-button wire:click="deleteMember" mode="danger">Delete</x-button>
        </x-slot>
    </x-confirmation-modal>
</div>