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
                sans: ['Plus Jakarta Sans', ...defaultTheme.fontFamily.sans],
                display: ['Plus Jakarta Sans', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                // Brand Colors - Gold/Amber
                amber: {
                    DEFAULT: '#D4A017',
                    light: '#E0B532',
                    dark: '#B8890D',
                    darker: '#9A7209',
                    50: '#FDF6E8',
                    100: '#FAE9C5',
                    200: '#F5D78B',
                    300: '#F0C151',
                    400: '#EBAA17',
                    500: '#D4A017',
                    600: '#B8890D',
                    700: '#9A7209',
                    800: '#7C5B06',
                    900: '#5E4404',
                },
                // Cream Background
                cream: {
                    DEFAULT: '#FDFBF4',
                    light: '#FEFDF8',
                    dark: '#F5F0E1',
                },
                // Dark Colors
                dark: {
                    DEFAULT: '#1A1A1A',
                    light: '#333333',
                    lighter: '#4A4A4A',
                },
                // White for cards
                white: '#FFFFFF',
            },
            boxShadow: {
                'amber': '0 4px 14px 0 rgba(212, 160, 23, 0.15)',
                'amber-lg': '0 10px 40px 0 rgba(212, 160, 23, 0.2)',
                'amber-sm': '0 2px 8px 0 rgba(212, 160, 23, 0.1)',
            },
            borderRadius: {
                'xl': '12px',
                '2xl': '16px',
                '3xl': '24px',
            },
            animation: {
                'float': 'float 4s ease-in-out infinite',
                'fade-in': 'fadeIn 0.8s ease-out forwards',
                'slide-up': 'slideUp 0.8s ease-out forwards',
            },
            keyframes: {
                float: {
                    '0%, 100%': { transform: 'translateY(0px)' },
                    '50%': { transform: 'translateY(-15px)' },
                },
                fadeIn: {
                    '0%': { opacity: '0' },
                    '100%': { opacity: '1' },
                },
                slideUp: {
                    '0%': { opacity: '0', transform: 'translateY(30px)' },
                    '100%': { opacity: '1', transform: 'translateY(0)' },
                },
            },
        },
    },

    plugins: [forms],
};
