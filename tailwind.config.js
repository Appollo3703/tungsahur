// tailwind.config.js
import defaultTheme from "tailwindcss/defaultTheme";
import forms from "@tailwindcss/forms";

/** @type {import('tailwindcss').Config} */
export default {
    prefix: 'tw-', // <--- TAMBAHKAN PREFIKS INI
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
    ],
    theme: {
        extend: {
            fontFamily: {
                sans: ["Figtree", ...defaultTheme.fontFamily.sans],
            },
            colors: {
                "custom-dark-blue": "#003366",
                "custom-light-text": "#f8f9fa",
                "custom-active-blue": "#75A5D1",
            },
        },
    },
    plugins: [forms],
};