@extends('layouts.admin')

@section('content')
<div class="py-8">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white shadow-xl rounded-xl overflow-hidden">
            <div class="p-8 bg-white">
                <!-- Header with back button -->
                <div class="flex items-center justify-between mb-8">
                    <div>
                        <h2 class="text-3xl font-bold text-gray-900">{{ isset($user) ? 'Edit' : 'Create' }} User</h2>
                        <p class="mt-1 text-sm text-gray-500">Manage user information and permissions</p>
                    </div>
                    <a href="{{ route('admin.members.index') }}"
                       class="inline-flex items-center px-4 py-2.5 bg-blue-600 border border-transparent rounded-lg font-medium text-sm text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        Back to Users
                    </a>
                </div>

                <!-- Form Card -->
                <div class="bg-gray-50 p-6 rounded-lg border border-gray-200">
                    <form method="POST" action="{{ isset($user) ? route('admin.users.update', $user->id) : route('admin.members.store') }}">
                        @csrf
                        @if(isset($user)) @method('PUT') @endif

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Name -->
                            <div class="space-y-2">
                                <x-input-label for="name" :value="__('Full Name')" class="font-medium text-gray-700"/>
                                <x-text-input id="name" class="block w-full rounded-lg" 
                                    type="text" 
                                    name="name" 
                                    :value="old('name', $user->name ?? '')" 
                                    required autofocus 
                                    placeholder="John Doe" />
                                <x-input-error :messages="$errors->get('name')" class="mt-1 text-sm"/>
                            </div>

                            <!-- Email -->
                            <div class="space-y-2">
                                <x-input-label for="email" :value="__('Email')" class="font-medium text-gray-700"/>
                                <x-text-input id="email" class="block w-full rounded-lg" 
                                    type="email" 
                                    name="email" 
                                    :value="old('email', $user->email ?? '')" 
                                    required 
                                    placeholder="user@example.com"/>
                                <x-input-error :messages="$errors->get('email')" class="mt-1 text-sm"/>
                            </div>

                            <!-- Phone -->
                            <div class="space-y-2">
                                <x-input-label for="phone" :value="__('Phone')" class="font-medium text-gray-700"/>
                                <x-text-input id="phone" class="block w-full rounded-lg" 
                                    type="tel" 
                                    name="phone" 
                                    :value="old('phone', $user->phone ?? '')" 
                                    required 
                                    placeholder="+255123456789"/>
                                <x-input-error :messages="$errors->get('phone')" class="mt-1 text-sm"/>
                            </div>

                            <!-- Address -->
                            <!-- <div class="space-y-2">
                                <x-input-label for="address" :value="__('Address')" class="font-medium text-gray-700"/>
                                <x-text-input id="address" class="block w-full rounded-lg" 
                                    type="text" 
                                    name="address" 
                                    :value="old('address', $user->address ?? '')" 
                                    required 
                                    placeholder="123 Main St"/>
                                <x-input-error :messages="$errors->get('address')" class="mt-1 text-sm"/>
                            </div> -->

                          
                            <!-- Date of Birth -->
                            <div class="space-y-2">
                                <x-input-label for="dob" :value="__('Date of Birth')" class="font-medium text-gray-700"/>
                                <x-text-input id="dob" class="block w-full rounded-lg" 
                                    type="date" 
                                    name="dob" 
                                    :value="old('dob', $user->dob ?? '')" 
                                    placeholder="YYYY-MM-DD"/>
                                <x-input-error :messages="$errors->get('dob')" class="mt-1 text-sm"/>
                            </div>

                            <!-- Gender -->
                            <div class="space-y-2">
                                <x-input-label for="gender" :value="__('Gender')" class="font-medium text-gray-700"/>
                                <select id="gender" name="gender"
                                        class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 transition duration-150">
                                    <option value="" disabled {{ old('gender', $user->gender ?? '') == '' ? 'selected' : '' }}>Select gender</option>
                                    <option value="male" {{ old('gender', $user->gender ?? '') == 'male' ? 'selected' : '' }}>Male</option>
                                    <option value="female" {{ old('gender', $user->gender ?? '') == 'female' ? 'selected' : '' }}>Female</option>
                                    <option value="other" {{ old('gender', $user->gender ?? '') == 'other' ? 'selected' : '' }}>Other</option>
                                </select>
                                <x-input-error :messages="$errors->get('gender')" class="mt-1 text-sm"/>
                            </div>

                           

                           <!-- Password -->
<div class="space-y-2">
    <label for="password" class="block font-medium text-gray-700">{{ __('Password') }}</label>
    <input id="password" name="password" type="password"
        class="block w-full rounded-lg border border-gray-300 px-3 py-2 text-sm shadow-sm focus:border-blue-500 focus:ring-blue-500"
        @isset($user) @else required @endisset
        placeholder="Enter password" />
    @error('password')
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
    @enderror
    @isset($user)
        <p class="mt-1 text-xs text-gray-500">Leave blank to keep current password</p>
    @endisset
</div>

<!-- Confirm Password -->
<div class="space-y-2 mt-4">
    <label for="password_confirmation" class="block font-medium text-gray-700">{{ __('Confirm Password') }}</label>
    <input id="password_confirmation" name="password_confirmation" type="password"
        class="block w-full rounded-lg border border-gray-300 px-3 py-2 text-sm shadow-sm focus:border-blue-500 focus:ring-blue-500"
        @isset($user) @else required @endisset
        placeholder="Confirm password" />
    @error('password_confirmation')
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>


                        <!-- Submit Button -->
                        <div class="mt-8">
                            <button type="submit"
                                    class="w-full inline-flex justify-center py-3 px-5 border border-transparent shadow-sm text-sm font-semibold rounded-lg text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition">
                                {{ isset($user) ? 'Update User' : 'Create User' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
