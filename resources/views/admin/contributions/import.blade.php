@extends('layouts.admin')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <h2 class="text-2xl font-semibold mb-6">Import Contributions</h2>

                <form action="{{ route('admin.members.import') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div>
                        <x-input-label for="file" :value="__('CSV File')" />
                        <x-text-input id="file" type="file" name="file" class="block mt-1 w-full" required />
                    </div>

                    <div class="flex items-center justify-end mt-6">
                        <x-primary-button>
                            Import Contributions
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
