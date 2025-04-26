<div class="flex items-center" x-data>
    <button
        type="button"
        class="relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-indigo-600 focus:ring-offset-2"
        :class="darkMode ? 'bg-indigo-600' : 'bg-gray-200'"
        @click="darkMode = !darkMode"
        role="switch"
        :aria-checked="darkMode"
    >
        <span class="sr-only">Toggle dark mode</span>
        <span
            aria-hidden="true"
            class="pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"
            :class="darkMode ? 'translate-x-5' : 'translate-x-0'"
        ></span>
    </button>
</div>
