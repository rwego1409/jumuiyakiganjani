import './bootstrap';

// Dark mode initialization
document.addEventListener('alpine:init', () => {
    Alpine.store('darkMode', {
        init() {
            this.syncFromStorage();
            this.setupSystemPreferenceListener();
            this.setupButtonListeners();
        },
        on: false,
        syncFromStorage() {
            this.on = localStorage.theme === 'dark' || 
                (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches);
            this.updateDOM();
        },
        toggle() {
            this.on = !this.on;
            this.updateDOM();
        },
        updateDOM() {
            document.documentElement.classList.toggle('dark', this.on);
            localStorage.theme = this.on ? 'dark' : 'light';
            this.updateDataTables();
        },
        setupSystemPreferenceListener() {
            window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', e => {
                if (!('theme' in localStorage)) {
                    this.on = e.matches;
                    this.updateDOM();
                }
            });
        },
        setupButtonListeners() {
            document.querySelectorAll('[data-dark-toggle], #themeToggle').forEach(button => {
                button.addEventListener('click', () => this.toggle());
            });
        },
        updateDataTables() {
            // Update DataTables if they exist
            if (typeof $.fn.DataTable !== 'undefined') {
                $('.dataTable').each(function() {
                    const table = $(this).DataTable();
                    if (table) {
                        table.draw();
                    }
                });
            }
        }
    });
    
    Alpine.store('darkMode').init();
});
// resources/js/app.js
window.Echo.private(`App.Models.User.${userId}`)
    .notification((notification) => {
        // Refresh Livewire component if using
        if (window.Livewire) {
            Livewire.emit('refreshNotifications');
        }
        
        // Show toast notification
        showToast(notification.title, notification.message);
    });

function showToast(title, message) {
    const toast = document.createElement('div');
    toast.className = 'fixed bottom-4 right-4 max-w-xs bg-white rounded-lg shadow-lg overflow-hidden';
    toast.innerHTML = `
        <div class="p-4">
            <div class="flex items-start">
                <div class="flex-shrink-0">
                    <svg class="h-6 w-6 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                    </svg>
                </div>
                <div class="ml-3 w-0 flex-1 pt-0.5">
                    <p class="text-sm font-medium text-gray-900">${title}</p>
                    <p class="mt-1 text-sm text-gray-500">${message}</p>
                </div>
            </div>
        </div>
    `;
    
    document.body.appendChild(toast);
    
    setTimeout(() => {
        toast.classList.add('opacity-0', 'transition-opacity', 'duration-300');
        setTimeout(() => toast.remove(), 300);
    }, 5000);
}