<button x-data @click="$store.darkMode.toggle()" type="button" class="relative inline-flex flex-shrink-0 h-6 w-11 border-2 border-transparent rounded-full cursor-pointer transition-colors ease-in-out duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 bg-gray-200 dark:bg-indigo-600" role="switch" aria-checked="false">
    <span class="sr-only">Toggle dark mode</span>
    <span aria-hidden="true" class="pointer-events-none inline-block h-5 w-5 rounded-full bg-white shadow transform ring-0 transition ease-in-out duration-200" :class="{ 'translate-x-5': $store.darkMode.on, 'translate-x-0': !$store.darkMode.on }">
    </span>
</button>
