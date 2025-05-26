<div class="p-4 border-b border-gray-200 dark:border-gray-700">
    <form action="{{ route('chairperson.resources.index') }}" method="GET" class="flex flex-wrap gap-4">
        <!-- Search -->
        <div class="flex-1 min-w-[200px]">
            <input type="text" name="search" value="{{ request('search') }}" 
                   placeholder="{{ __('Search resources...') }}"
                   class="w-full rounded-md shadow-sm border-gray-300 dark:border-gray-700 
                          dark:bg-gray-900 dark:text-gray-300 focus:border-primary-500 focus:ring-primary-500">
        </div>

        <!-- Type Filter -->
        <div class="w-full sm:w-auto">
            <select name="type" 
                    class="w-full rounded-md shadow-sm border-gray-300 dark:border-gray-700 
                           dark:bg-gray-900 dark:text-gray-300 focus:border-primary-500 focus:ring-primary-500">
                <option value="">{{ __('All Types') }}</option>
                <option value="document" {{ request('type') === 'document' ? 'selected' : '' }}>{{ __('Document') }}</option>
                <option value="video" {{ request('type') === 'video' ? 'selected' : '' }}>{{ __('Video') }}</option>
                <option value="audio" {{ request('type') === 'audio' ? 'selected' : '' }}>{{ __('Audio') }}</option>
                <option value="image" {{ request('type') === 'image' ? 'selected' : '' }}>{{ __('Image') }}</option>
                <option value="other" {{ request('type') === 'other' ? 'selected' : '' }}>{{ __('Other') }}</option>
            </select>
        </div>

        <!-- Status Filter -->
        <div class="w-full sm:w-auto">
            <select name="status" 
                    class="w-full rounded-md shadow-sm border-gray-300 dark:border-gray-700 
                           dark:bg-gray-900 dark:text-gray-300 focus:border-primary-500 focus:ring-primary-500">
                <option value="">{{ __('All Statuses') }}</option>
                <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>{{ __('Active') }}</option>
                <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>{{ __('Inactive') }}</option>
            </select>
        </div>

        <!-- Submit & Reset -->
        <div class="flex gap-2">
            <button type="submit" 
                    class="bg-primary-500 hover:bg-primary-600 text-white px-4 py-2 rounded-md">
                <i class="fas fa-search mr-2"></i>{{ __('Filter') }}
            </button>
            <a href="{{ route('chairperson.resources.index') }}" 
               class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-md">
                <i class="fas fa-sync-alt mr-2"></i>{{ __('Reset') }}
            </a>
        </div>
    </form>
</div>
