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
                sans: ['Inter', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                // Academic Excellence Portal — Design System
                primary: {
                    DEFAULT: '#005f2d',
                    container: '#0e7a3d',
                    fixed: '#97f7ac',
                    'fixed-dim': '#7bda92',
                },
                'on-primary': '#ffffff',
                'on-primary-container': '#a5ffb7',
                'on-primary-fixed': '#00210b',
                'on-primary-fixed-variant': '#005226',
                secondary: {
                    DEFAULT: '#5c5f61',
                    container: '#e0e3e5',
                    fixed: '#e0e3e5',
                    'fixed-dim': '#c4c7c9',
                },
                'on-secondary': '#ffffff',
                'on-secondary-container': '#626567',
                tertiary: {
                    DEFAULT: '#495362',
                    container: '#616b7b',
                    fixed: '#d9e3f6',
                    'fixed-dim': '#bdc7d9',
                },
                'on-tertiary': '#ffffff',
                'on-tertiary-container': '#e2ecff',
                'on-tertiary-fixed': '#121c2a',
                'on-tertiary-fixed-variant': '#3d4756',
                error: {
                    DEFAULT: '#ba1a1a',
                    container: '#ffdad6',
                },
                'on-error': '#ffffff',
                'on-error-container': '#93000a',
                surface: {
                    DEFAULT: '#f6fafe',
                    dim: '#d6dade',
                    bright: '#f6fafe',
                    'container-lowest': '#ffffff',
                    'container-low': '#f0f4f8',
                    container: '#eaeef2',
                    'container-high': '#e4e9ed',
                    'container-highest': '#dfe3e7',
                    tint: '#006d34',
                    variant: '#dfe3e7',
                },
                'on-surface': '#171c1f',
                'on-surface-variant': '#3f493f',
                'inverse-surface': '#2c3134',
                'inverse-on-surface': '#edf1f5',
                'inverse-primary': '#7bda92',
                background: '#f6fafe',
                'on-background': '#171c1f',
                outline: {
                    DEFAULT: '#6f7a6e',
                    variant: '#becabc',
                },
            },
            borderRadius: {
                xl: '0.75rem',
                '2xl': '1rem',
                '3xl': '1.5rem',
            },
            boxShadow: {
                soft: '0 1px 3px rgba(0,0,0,0.05), 0 4px 6px rgba(0,0,0,0.02)',
            },
        },
    },

    plugins: [forms],
};
