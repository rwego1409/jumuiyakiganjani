@extends('layouts.admin')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-2xl font-semibold">Contribution Details</h2>
                    <div class="space-x-4">
                        <a href="{{ route('admin.contributions.edit', $contribution) }}" class="btn-primary">
                            Edit Contribution
                        </a>
                        <a href="{{ route('admin.contributions.index') }}" class="btn-secondary">
                            Back to List
                        </a>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-gray-50 p-6 rounded-lg">
                        <h3 class="text-lg font-medium mb-4">Contribution Information</h3>
                        <dl class="space-y-4">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Member</dt>
                                <dd class="mt-1 text-gray-900">{{ $contribution->member->user->name }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Amount</dt>
                                <dd class="mt-1 text-gray-900">TZS {{ number_format($contribution->amount) }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Date</dt>
                                <dd class="mt-1 text-gray-900">{{ $contribution->contribution_date->format('M d, Y') }}</dd>
                            </div>
                        </dl>
                    </div>

                    <div class="bg-gray-50 p-6 rounded-lg">
                        <h3 class="text-lg font-medium mb-4">Payment Details</h3>
                        <dl class="space-y-4">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Payment Method</dt>
                                <dd class="mt-1 text-gray-900">{{ ucfirst($contribution->payment_method) }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Purpose</dt>
                                <dd class="mt-1 text-gray-900">{{ $contribution->purpose ?? 'General Contribution' }}</dd>
                            </div>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection