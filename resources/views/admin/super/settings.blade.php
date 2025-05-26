@extends('layouts.dashboard')

@section('title', 'System Settings')

@section('content')
<div class="container px-6 mx-auto grid">
    <h2 class="my-6 text-2xl font-semibold text-gray-700">
        System Settings
    </h2>

    @if(session('success'))
    <div class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg" role="alert">
        {{ session('success') }}
    </div>
    @endif

    <div class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md">
        <form action="{{ route('super_admin.settings.update') }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="block text-sm">
                    <span class="text-gray-700">Site Name</span>
                    <input type="text" name="site_name" value="{{ old('site_name', $settings->site_name) }}" required
                           class="block w-full mt-1 text-sm focus:border-purple-400 focus:outline-none focus:shadow-outline-purple form-input">
                </label>
                @error('site_name')
                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-sm">
                    <span class="text-gray-700">Site Description</span>
                    <textarea name="site_description" rows="3"
                              class="block w-full mt-1 text-sm focus:border-purple-400 focus:outline-none focus:shadow-outline-purple form-textarea">{{ old('site_description', $settings->site_description) }}</textarea>
                </label>
                @error('site_description')
                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-sm">
                    <span class="text-gray-700">Contact Email</span>
                    <input type="email" name="contact_email" value="{{ old('contact_email', $settings->contact_email) }}" required
                           class="block w-full mt-1 text-sm focus:border-purple-400 focus:outline-none focus:shadow-outline-purple form-input">
                </label>
                @error('contact_email')
                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-sm">
                    <span class="text-gray-700">Contact Phone</span>
                    <input type="text" name="contact_phone" value="{{ old('contact_phone', $settings->contact_phone) }}" required
                           class="block w-full mt-1 text-sm focus:border-purple-400 focus:outline-none focus:shadow-outline-purple form-input">
                </label>
                @error('contact_phone')
                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center mt-4">
                <input type="checkbox" name="maintenance_mode" value="1" {{ old('maintenance_mode', $settings->maintenance_mode) ? 'checked' : '' }}
                       class="text-purple-600 form-checkbox focus:border-purple-400 focus:outline-none focus:shadow-outline-purple">
                <span class="ml-2">
                    Enable Maintenance Mode
                </span>
            </div>

            <div class="flex items-center mt-4">
                <input type="checkbox" name="allow_registrations" value="1" {{ old('allow_registrations', $settings->allow_registrations) ? 'checked' : '' }}
                       class="text-purple-600 form-checkbox focus:border-purple-400 focus:outline-none focus:shadow-outline-purple">
                <span class="ml-2">
                    Allow New Registrations
                </span>
            </div>

            <div class="mt-6">
                <button type="submit"
                        class="px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
                    Save Settings
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
