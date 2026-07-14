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
                // ── Primary (School Green) ──────────────────────────
                primary:            '#005f2d',
                'on-primary':       '#ffffff',
                'primary-container':'#0e7a3d',
                'on-primary-container': '#a5ffb7',
                'primary-fixed':    '#97f7ac',
                'primary-fixed-dim':'#7bda92',
                'on-primary-fixed': '#00210b',
                'on-primary-fixed-variant': '#005226',
                'inverse-primary':  '#7bda92',

                // ── Secondary ────────────────────────────────────────
                secondary:          '#5c5f61',
                'on-secondary':     '#ffffff',
                'secondary-container': '#e0e3e5',
                'on-secondary-container': '#626567',
                'secondary-fixed':  '#e0e3e5',
                'secondary-fixed-dim': '#c4c7c9',
                'on-secondary-fixed': '#191c1e',
                'on-secondary-fixed-variant': '#444749',

                // ── Tertiary ─────────────────────────────────────────
                tertiary:           '#495362',
                'on-tertiary':      '#ffffff',
                'tertiary-container': '#616b7b',
                'on-tertiary-container': '#e2ecff',
                'tertiary-fixed':   '#d9e3f6',
                'tertiary-fixed-dim': '#bdc7d9',
                'on-tertiary-fixed': '#121c2a',
                'on-tertiary-fixed-variant': '#3d4756',

                // ── Error ────────────────────────────────────────────
                error:              '#ba1a1a',
                'on-error':         '#ffffff',
                'error-container':  '#ffdad6',
                'on-error-container': '#93000a',

                // ── Surface scale ────────────────────────────────────
                surface:            '#f6fafe',
                'surface-dim':      '#d6dade',
                'surface-bright':   '#f6fafe',
                'surface-container-lowest': '#ffffff',
                'surface-container-low': '#f0f4f8',
                'surface-container':'#eaeef2',
                'surface-container-high': '#e4e9ed',
                'surface-container-highest': '#dfe3e7',
                'surface-tint':     '#006d34',
                'surface-variant':  '#dfe3e7',
                'on-surface':       '#171c1f',
                'on-surface-variant': '#3f493f',
                'inverse-surface':  '#2c3134',
                'inverse-on-surface': '#edf1f5',

                // ── Background ───────────────────────────────────────
                background:         '#f6fafe',
                'on-background':    '#171c1f',

                // ── Outline ──────────────────────────────────────────
                outline:            '#6f7a6e',
                'outline-variant':  '#becabc',
            },
            boxShadow: {
                soft: '0 1px 3px rgba(0,0,0,0.05), 0 4px 6px rgba(0,0,0,0.02)',
            },
        },
    },

    plugins: [forms],
};
