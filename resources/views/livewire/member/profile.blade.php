<div>
    {{-- Be like water. --}}
</div>
<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('My Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="max-w-3xl mx-auto">
                        <div class="flex flex-col items-center mb-8">
                            <div class="relative">
                                <img class="h-32 w-32 rounded-full" src="{{ auth()->user()->profile_photo_url }}" alt="Profile Photo">
                            </div>
                            <h2 class="mt-4 text-2xl font-bold text-gray-900">
                                {{ auth()->user()->name }}
                            </h2>
                            <p class="mt-1 text-gray-600">{{ auth()->user()->email }}</p>
                        </div>

                        <form wire:submit.prevent="saveProfile">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <x-input wire:model="user.name" label="Full Name" />
                                <x-input wire:model="user.email" type="email" label="Email" />
                                <x-input wire:model="member.phone" label="Phone Number" />
                                <x-input wire:model="member.address" label="Address" />
                                <x-input wire:model="member.birth_date" type="date" label="Birth Date" />
                                <x-input wire:model="member.joined_date" type="date" label="Joined Date" disabled />
                            </div>

                            <div class="mt-6 flex justify-end">
                                <x-button type="submit" mode="primary">
                                    Save Changes
                                </x-button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>