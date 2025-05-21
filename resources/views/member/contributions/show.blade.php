<!-- resources/views/member/contributions/show.blade.php -->
<div class="bg-white rounded-lg shadow-md overflow-hidden">
    <div class="p-6">
        <div class="flex justify-between items-start">
            <div>
<h3 class="text-2xl font-bold text-gray-800">
    {{ $contribution->course ? $contribution->course->name : 'Course not available' }}
</h3>

                <p class="text-gray-600 mt-1">Due by: {{ $contribution->due_date ? $contribution->due_date->format('M d, Y') : 'No due date' }}</p>

            </div>
            <span class="px-3 py-1 rounded-full text-sm font-medium 
                {{ $contribution->is_complete ? 'bg-green-100 text-green-800' : ($contribution->is_overdue ? 'bg-red-100 text-red-800' : 'bg-blue-100 text-blue-800') }}">
                {{ $contribution->status_text }}
            </span>
        </div>

        <!-- Progress Section -->
        <div class="mt-6">
            <div class="flex justify-between items-center mb-2">
                <h4 class="font-medium text-gray-700">Payment Progress</h4>
                <span class="text-sm font-semibold {{ $contribution->is_complete ? 'text-green-600' : 'text-indigo-600' }}">
                    {{ number_format($contribution->progress, 1) }}% Complete
                </span>
            </div>
            
            <div class="w-full bg-gray-200 rounded-full h-2.5 mb-2">
                <div class="h-2.5 rounded-full {{ $contribution->is_complete ? 'bg-green-500' : 'bg-indigo-600' }}" 
                     style="width: {{ $contribution->progress }}%"></div>
            </div>
            
            <div class="flex justify-between text-sm text-gray-600">
                <span>Paid: {{ number_format($contribution->paid_amount) }} TZS</span>
                <span>Total: {{ number_format($contribution->amount) }} TZS</span>
                <span>Balance: {{ number_format($contribution->balance) }} TZS</span>
            </div>
        </div>

        <!-- Payment History -->
        <div class="mt-8">
            <h4 class="font-medium text-gray-700 mb-3">Recent Payments</h4>
            
           @if($contribution->payments && $contribution->payments->isEmpty())
    <p class="text-gray-500 text-sm">No payments recorded yet</p>
@elseif($contribution->payments)
    <div class="space-y-3">
        @foreach($contribution->payments->take(3) as $payment)
        <div class="border-l-4 border-indigo-500 pl-4 py-2">
            <div class="flex justify-between">
                <div>
                    <p class="font-medium">{{ number_format($payment->amount) }} TZS</p>
                    <p class="text-sm text-gray-500">{{ $payment->created_at->format('M d, Y - h:i A') }}</p>
                </div>
                <div class="text-right">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                        {{ ucfirst($payment->payment_method) }}
                    </span>
                </div>
            </div>
        </div>
        @endforeach
    </div>
@endif

                </div>
                
               @if($contribution->payments && $contribution->payments->count() > 3)
    <a href="{{ route('member.contributions.payments', $contribution) }}"
       class="inline-block mt-3 text-sm text-indigo-600 hover:text-indigo-800">
        View all {{ $contribution->payments->count() }} payments →
    </a>
@endif

           
        </div>

        <!-- Payment Actions -->
        <div class="mt-8 pt-5 border-t border-gray-200">
            <div class="flex flex-col sm:flex-row gap-3">
                <a href="{{ route('member.payments.create', $contribution) }}" 
                   class="flex-1 inline-flex items-center justify-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md shadow-sm text-sm font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Make Payment
                </a>
                
                <a href="{{ route('member.contributions.history', $contribution) }}" 
                   class="flex-1 inline-flex items-center justify-center px-4 py-2 bg-white border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <svg class="-ml-1 mr-2 h-5 w-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                    Payment History
                </a>
            </div>
        </div>
    </div>
</div>