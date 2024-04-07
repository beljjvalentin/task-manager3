/** @type {import('tailwindcss').Config} */
export default {
    content: [],
    purge: [
        './index.html',
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
        './src/**/*.{vue,js,ts,jsx,tsx}'
    ],
    theme: {
        extend: {},
    },
    plugins: [],
}

