@extends('layouts.admin')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <h2 class="text-2xl font-semibold mb-6">Upload New Resource</h2>
                
                <form method="POST" action="{{ route('admin.resources.store') }}" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <x-input-label for="title" :value="__('Title')" />
                            <x-text-input id="title" class="block mt-1 w-full" 
                                type="text" 
                                name="title" 
                                required />
                        </div>

                        <div>
    <x-input-label for="type" :value="__('Resource Type')" />
    <select id="type" name="type" class="block mt-1 w-full" required>
        <option value="bible">Bible</option>
        <option value="document">Document</option>
        <option value="news">News</option>
    </select>
</div>


                        <div class="md:col-span-2">
                            <x-input-label for="description" :value="__('Description')" />
                            <x-text-area id="description" name="description" class="block mt-1 w-full" rows="3" />
                        </div>

                        <div class="md:col-span-2">
                            <x-input-label for="file" :value="__('File Upload')" />
                            <x-file-input id="file" name="file" class="block mt-1 w-full" required />
                        </div>
                    </div>

                    <div class="flex items-center justify-end mt-6">
                        <x-primary-button>
                            Upload Resource
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection