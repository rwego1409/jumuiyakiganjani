import './bootstrap';

// Dark mode initialization
document.addEventListener('DOMContentLoaded', () => {
    // Check for dark mode preference
    const isDark = localStorage.theme === 'dark' || 
        (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches);
    
    // Set initial dark mode
    document.documentElement.classList.toggle('dark', isDark);

    // Handle dark mode toggle clicks
    document.querySelectorAll('[data-dark-toggle]').forEach(button => {
        button.addEventListener('click', () => {
            document.documentElement.classList.toggle('dark');
            localStorage.theme = document.documentElement.classList.contains('dark') ? 'dark' : 'light';
        });
    });
});

// Add Dark Mode Store
document.addEventListener('alpine:init', () => {
    Alpine.store('darkMode', {
        on: localStorage.getItem('darkMode') === 'true',
        toggle() {
            this.on = !this.on;
            localStorage.setItem('darkMode', this.on);
            document.documentElement.classList.toggle('dark', this.on);
        }
    });
});

// Initialize dark mode
if (localStorage.getItem('darkMode') === 'true' || 
    (!('darkMode' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
    document.documentElement.classList.add('dark');
    Alpine.store('darkMode').on = true;
}

// Initialize dark mode on page load
if (localStorage.getItem('darkMode') === 'true' || 
    (!('darkMode' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
    document.documentElement.classList.add('dark');
}
