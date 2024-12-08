import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import typography from '@tailwindcss/typography';
const { iconsPlugin, getIconCollections } = require("@egoist/tailwindcss-icons");
/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './vendor/laravel/jetstream/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
        },
    },

    plugins: [
        forms,
        typography,
        iconsPlugin({
        // Select the icon collections you want to use
        // You can also ignore this option to automatically discover all individual icon packages you have installed
        // If you install @iconify/json, you should explicitly specify the collections you want to use, like this:
        collections: getIconCollections(["mdi", "lucide"]),
        // If you want to use all icons from @iconify/json, you can do this:
        // collections: getIconCollections("all"),
        // and the more recommended way is to use `dynamicIconsPlugin`, see below.
      }),],
};
