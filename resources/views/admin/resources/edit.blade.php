@extends('layouts.admin')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <h2 class="text-2xl font-semibold mb-6">Edit Resource</h2>
                
                <form method="POST" action="{{ route('admin.resources.update', $resource) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <!-- Similar fields to create.blade.php with existing values -->
                    
                    <div class="flex items-center justify-end mt-6">
                        <x-primary-button>
                            Update Resource
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection