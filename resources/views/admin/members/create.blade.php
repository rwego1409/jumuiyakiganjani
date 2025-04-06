@extends('layouts.admin')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <h2 class="text-2xl font-semibold mb-6">{{ isset($member) ? 'Edit' : 'Create' }} Member</h2>
                
                <form method="POST" action="{{ isset($member) ? route('admin.members.update', $member->id) : route('admin.members.store') }}">
                    @csrf
                    @if(isset($member)) @method('PUT') @endif

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <x-input-label for="name" :value="__('Full Name')" />
                            <x-text-input id="name" class="block mt-1 w-full" 
                                type="text" 
                                name="name" 
                                :value="old('name', $member->user->name ?? '')" 
                                required autofocus />
                        </div>

                        <div>
    <x-input-label for="jumuiya_id" :value="__('Jumuiya')" />
    <select id="jumuiya_id" name="jumuiya_id" class="block mt-1 w-full" required>
        @foreach($jumuiyas as $jumuiya)
            <option value="{{ $jumuiya->id }}" 
                {{ (old('jumuiya_id', $member->jumuiya_id ?? '') == $jumuiya->id) ? 'selected' : '' }}>
                {{ $jumuiya->name }}
            </option>
        @endforeach
    </select>
</div>


                        <!-- Add more form fields as needed -->
                    </div>

                    <div class="flex items-center justify-end mt-6">
                        <x-primary-button>
                            {{ isset($member) ? 'Update' : 'Create' }} Member
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection