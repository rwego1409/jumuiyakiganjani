<div class="p-4 border-b border-gray-200 dark:border-gray-700">
    <form action="{{ route('chairperson.events.index') }}" method="GET" class="flex flex-wrap gap-4">
        <!-- Search -->
        <div class="flex-1 min-w-[200px]">
            <input type="text" name="search" value="{{ request('search') }}" 
                   placeholder="{{ __('Search events...') }}"
                   class="w-full rounded-md shadow-sm border-gray-300 dark:border-gray-700 
                          dark:bg-gray-900 dark:text-gray-300 focus:border-primary-500 focus:ring-primary-500">
        </div>

        <!-- Status Filter -->
        <div class="w-full sm:w-auto">
            <select name="status" 
                    class="w-full rounded-md shadow-sm border-gray-300 dark:border-gray-700 
                           dark:bg-gray-900 dark:text-gray-300 focus:border-primary-500 focus:ring-primary-500">
                <option value="">{{ __('All Statuses') }}</option>
                <option value="upcoming" {{ request('status') === 'upcoming' ? 'selected' : '' }}>{{ __('Upcoming') }}</option>
                <option value="ongoing" {{ request('status') === 'ongoing' ? 'selected' : '' }}>{{ __('Ongoing') }}</option>
                <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>{{ __('Completed') }}</option>
            </select>
        </div>

        <!-- Date Range -->
        <div class="w-full sm:w-auto">
            <input type="date" name="start_date" value="{{ request('start_date') }}"
                   class="w-full rounded-md shadow-sm border-gray-300 dark:border-gray-700 
                          dark:bg-gray-900 dark:text-gray-300 focus:border-primary-500 focus:ring-primary-500"
                   placeholder="{{ __('Start Date') }}">
        </div>
        <div class="w-full sm:w-auto">
            <input type="date" name="end_date" value="{{ request('end_date') }}"
                   class="w-full rounded-md shadow-sm border-gray-300 dark:border-gray-700 
                          dark:bg-gray-900 dark:text-gray-300 focus:border-primary-500 focus:ring-primary-500"
                   placeholder="{{ __('End Date') }}">
        </div>

        <!-- Submit & Reset -->
        <div class="flex gap-2">
            <button type="submit" 
                    class="bg-primary-500 hover:bg-primary-600 text-white px-4 py-2 rounded-md">
                <i class="fas fa-search mr-2"></i>{{ __('Filter') }}
            </button>
            <a href="{{ route('chairperson.events.index') }}" 
               class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-md">
                <i class="fas fa-sync-alt mr-2"></i>{{ __('Reset') }}
            </a>
        </div>
    </form>
</div>
