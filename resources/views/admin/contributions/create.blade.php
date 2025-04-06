@extends('layouts.admin')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <h2 class="text-2xl font-semibold mb-6">Record New Contribution</h2>
                
                <form method="POST" action="{{ route('admin.contributions.store') }}">
                    @csrf
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <x-input-label for="member_id" :value="__('Member')" />
                            <x-select-input id="member_id" name="member_id" class="block mt-1 w-full" :label="__('Member')" :options="$members->pluck('user.name', 'id')" required />
                        </div>

                        <div>
                            <x-input-label for="amount" :value="__('Amount (TZS)')" />
                            <x-text-input id="amount" class="block mt-1 w-full" 
                                type="number" 
                                name="amount" 
                                required />
                        </div>

                        <div>
                            <x-input-label for="contribution_date" :value="__('Contribution Date')" />
                            <x-text-input id="contribution_date" class="block mt-1 w-full" 
                                type="date" 
                                name="contribution_date" 
                                required />
                        </div>

                        <div>
                            <x-input-label for="payment_method" :value="__('Payment Method')" />
                            <x-select-input id="payment_method" name="payment_method" class="block mt-1 w-full" :label="__('Payment Method')" :options="['cash' => 'Cash', 'mobile' => 'Mobile Payment', 'bank' => 'Bank Transfer']" required />
                        </div>

                        <div class="md:col-span-2">
                            <x-input-label for="purpose" :value="__('Purpose')" />
                            <x-text-area id="purpose" name="purpose" :label="__('Purpose')" class="block mt-1 w-full" rows="3" />
                        </div>
                    </div>

                    <div class="flex items-center justify-end mt-6">
                        <x-primary-button>
                            Record Contribution
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
