import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import typography from '@tailwindcss/typography';

/** @type {import('tailwindcss').Config} */
export default {
    darkMode: 'class', // Enable dark mode via class

    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue', // If using Vue
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                primary: {
                    50: '#f0f9ff',
                    100: '#e0f2fe',
                    200: '#bae6fd',
                    300: '#7dd3fc',
                    400: '#38bdf8',
                    500: '#0ea5e9', // Main primary color
                    600: '#0284c7',
                    700: '#0369a1',
                    800: '#075985',
                    900: '#0c4a6e',
                },
                jumuiya: {
                    blue: '#2563eb',
                    green: '#16a34a',
                    purple: '#7e22ce',
                    gold: '#d97706',
                },
            },
            backgroundImage: {
                'community-pattern': "url('/images/community-bg.svg')",
            },
        },
    },

    plugins: [
        forms,
        typography,
        function({ addComponents }) {
            addComponents({
                '.btn-jumuiya': {
                    backgroundColor: '#2563eb',
                    color: '#fff',
                    padding: '0.5rem 1rem',
                    borderRadius: '0.375rem',
                    fontWeight: '600',
                    '&:hover': {
                        backgroundColor: '#1d4ed8',
                    },
                },
                '.card-jumuiya': {
                    backgroundColor: '#fff',
                    borderRadius: '0.5rem',
                    boxShadow: '0 1px 3px 0 rgb(0 0 0 / 0.1), 0 1px 2px -1px rgb(0 0 0 / 0.1)',
                    padding: '1.5rem',
                },
            });
        },
    ],
};
