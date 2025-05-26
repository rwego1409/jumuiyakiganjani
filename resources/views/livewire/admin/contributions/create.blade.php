<div>
    <form wire:submit.prevent="save">
        <div class="space-y-6">
            <!-- Jumuiya Selection -->
            <div>
                <label for="jumuiya_id" class="block text-sm font-medium text-gray-700">Jumuiya</label>
                <select wire:model.live="form.jumuiya_id" id="jumuiya_id" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                    <option value="">Select Jumuiya</option>
                    @foreach($jumuiyas as $jumuiya)
                        <option value="{{ $jumuiya->id }}">{{ $jumuiya->name }}</option>
                    @endforeach
                </select>
                @error('form.jumuiya_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <!-- Member Selection -->
            <div>
                <label for="member_id" class="block text-sm font-medium text-gray-700">Member</label>
                <select wire:model="form.member_id" id="member_id" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md" @if(!$form['jumuiya_id']) disabled @endif>
                    <option value="">Select Member</option>
                    @foreach($members as $member)
                        <option value="{{ $member->id }}">{{ $member->user->name }}</option>
                    @endforeach
                </select>
                @error('form.member_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <!-- Amount -->
            <div>
                <label for="amount" class="block text-sm font-medium text-gray-700">Amount (TZS)</label>
                <div class="mt-1">
                    <input type="number" wire:model="form.amount" id="amount" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md" placeholder="1000">
                </div>
                @error('form.amount') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <!-- Contribution Date -->
            <div>
                <label for="contribution_date" class="block text-sm font-medium text-gray-700">Contribution Date</label>
                <div class="mt-1">
                    <input type="date" wire:model="form.contribution_date" id="contribution_date" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                </div>
                @error('form.contribution_date') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <!-- Payment Method -->
            <div>
                <label for="payment_method" class="block text-sm font-medium text-gray-700">Payment Method</label>
                <select wire:model="form.payment_method" id="payment_method" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                    <option value="mobile">Mobile Payment</option>
                    <option value="cash">Cash</option>
                    <option value="bank">Bank Transfer</option>
                </select>
                @error('form.payment_method') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <!-- Purpose -->
            <div>
                <label for="purpose" class="block text-sm font-medium text-gray-700">Purpose</label>
                <div class="mt-1">
                    <textarea wire:model="form.purpose" id="purpose" rows="3" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md" placeholder="Purpose of contribution"></textarea>
                </div>
                @error('form.purpose') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <!-- Status -->
            <div>
                <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                <select wire:model="form.status" id="status" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                    <option value="pending">Pending</option>
                    <option value="confirmed">Confirmed</option>
                    <option value="rejected">Rejected</option>
                </select>
                @error('form.status') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="pt-5">
                <div class="flex justify-end">
                    <button type="submit" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Create Contribution
                    </button>
                </div>
            </div>
        </div>
    </form>

    @if (session()->has('success'))
        <div class="rounded-md bg-green-50 p-4 mt-6">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-green-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-green-800">
                        {{ session('success') }}
                    </p>
                </div>
            </div>
        </div>
    @endif

    @if (session()->has('error'))
        <div class="rounded-md bg-red-50 p-4 mt-6">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-red-800">
                        {{ session('error') }}
                    </p>
                </div>
            </div>
        </div>
    @endif
</div>
