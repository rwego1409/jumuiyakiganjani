<div class="min-h-screen bg-gradient-to-br from-pink-50 via-white to-purple-100 dark:from-pink-900 dark:via-gray-800 dark:to-purple-900 py-12">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white/80 dark:bg-purple-900/80 backdrop-blur-md shadow-2xl rounded-2xl border border-pink-200/60 dark:border-purple-700/60 p-8">
            <div class="mb-6 flex items-center gap-3">
                <svg class="w-8 h-8 text-pink-500 dark:text-pink-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                <h2 class="text-2xl font-bold bg-gradient-to-r from-pink-600 to-purple-600 bg-clip-text text-transparent drop-shadow-lg">{{ __('Add New Member') }}</h2>
            </div>
            <!-- Member creation form here -->

            <div class="mt-10">
                <h3 class="text-lg font-semibold mb-2 text-pink-700 dark:text-pink-200">Test ClickPesa USSD Payment</h3>
                <form method="POST" action="/clickpesa/ussd" class="space-y-4 bg-pink-50 dark:bg-purple-800/40 p-4 rounded-xl">
                    @csrf
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">Phone (format: 2557XXXXXXXX)</label>
                        <input type="text" name="phone" class="mt-1 block w-full rounded border-gray-300 dark:bg-gray-900 dark:text-white" required />
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">Amount (TZS)</label>
                        <input type="number" name="amount" class="mt-1 block w-full rounded border-gray-300 dark:bg-gray-900 dark:text-white" required min="100" />
                    </div>
                    <button type="submit" class="bg-pink-600 hover:bg-pink-700 text-white font-bold py-2 px-4 rounded shadow">Pay with ClickPesa USSD</button>
                </form>
            </div>
        </div>
    </div>
</div>