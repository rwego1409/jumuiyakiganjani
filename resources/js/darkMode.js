export const initDarkMode = () => {
    // Check system/saved preference
    if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
        document.documentElement.classList.add('dark');
    }

    // Add listeners to all dark mode toggle buttons
    document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('[data-dark-toggle]').forEach(button => {
            button.addEventListener('click', () => {
                document.documentElement.classList.toggle('dark');
                localStorage.theme = document.documentElement.classList.contains('dark') ? 'dark' : 'light';
            });
        });

        // Watch for system theme changes
        window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', e => {
            if (!('theme' in localStorage)) {
                document.documentElement.classList.toggle('dark', e.matches);
            }
        });
    });
};
