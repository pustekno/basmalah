import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
                display: ['Sora', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                primary: {
                    DEFAULT: '#B8860B',
                    light: '#DAA520',
                    lightest: '#FEF3C7',
                    dark: '#8B6508',
                    darker: '#654C0F',
                },
                dark: {
                    DEFAULT: '#1a1a1a',
                    light: '#333333',
                    lighter: '#4a4a4a',
                }
            }
        },
    },

    plugins: [forms],
};
