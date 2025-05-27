<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ isset($jumuiya) ? __('Edit Jumuiya') : __('Create New Jumuiya') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="POST" action="{{ isset($jumuiya) ? route('super_admin.jumuiyas.update', $jumuiya) : route('super_admin.jumuiyas.store') }}">
                        @csrf
                        @if(isset($jumuiya))
                            @method('PUT')
                        @endif

                        <!-- Jumuiya Information -->
                        <div class="mb-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Jumuiya Information</h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Name -->
                                <div>
                                    <x-input-label for="name" :value="__('Jumuiya Name')" />
                                    <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $jumuiya->name ?? '')" required autofocus />
                                    <x-input-error class="mt-2" :messages="$errors->get('name')" />
                                </div>

                                <!-- Location -->
                                <div>
                                    <x-input-label for="location" :value="__('Location')" />
                                    <x-text-input id="location" name="location" type="text" class="mt-1 block w-full" :value="old('location', $jumuiya->location ?? '')" required />
                                    <x-input-error class="mt-2" :messages="$errors->get('location')" />
                                </div>
                            </div>

                            <!-- Description -->
                            <div class="mt-4">
                                <x-input-label for="description" :value="__('Description')" />
                                <textarea id="description" name="description" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" rows="3">{{ old('description', $jumuiya->description ?? '') }}</textarea>
                                <x-input-error class="mt-2" :messages="$errors->get('description')" />
                            </div>
                        </div>

                        @unless(isset($jumuiya))
                        <!-- Chairperson Information -->
                        <div class="mb-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Chairperson Information</h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Chairperson Name -->
                                <div>
                                    <x-input-label for="chairperson_name" :value="__('Chairperson Name')" />
                                    <x-text-input id="chairperson_name" name="chairperson_name" type="text" class="mt-1 block w-full" :value="old('chairperson_name')" required />
                                    <x-input-error class="mt-2" :messages="$errors->get('chairperson_name')" />
                                </div>

                                <!-- Chairperson Email -->
                                <div>
                                    <x-input-label for="chairperson_email" :value="__('Chairperson Email')" />
                                    <x-text-input id="chairperson_email" name="chairperson_email" type="email" class="mt-1 block w-full" :value="old('chairperson_email')" required />
                                    <x-input-error class="mt-2" :messages="$errors->get('chairperson_email')" />
                                </div>

                                <!-- Chairperson Phone -->
                                <div>
                                    <x-input-label for="chairperson_phone" :value="__('Chairperson Phone')" />
                                    <x-text-input id="chairperson_phone" name="chairperson_phone" type="text" class="mt-1 block w-full" :value="old('chairperson_phone')" required placeholder="255700000000" />
                                    <x-input-error class="mt-2" :messages="$errors->get('chairperson_phone')" />
                                </div>
                            </div>
                        </div>
                        @endunless

                        <div class="flex items-center justify-end mt-6">
                            <x-secondary-button type="button" onclick="window.history.back();" class="mr-3">
                                {{ __('Cancel') }}
                            </x-secondary-button>
                            
                            <x-primary-button>
                                {{ isset($jumuiya) ? __('Update Jumuiya') : __('Create Jumuiya') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
