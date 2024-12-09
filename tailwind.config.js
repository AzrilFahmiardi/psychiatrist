import defaultTheme from 'tailwindcss/defaultTheme';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
    ],
    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
                poppins: ["Poppins", "sans-serif"],

            },
            backgroundImage: {
                "login-gradient":
                  "linear-gradient(to bottom right, #FAFAFA 0%, #51B2B8 50%, #155458 100%)",
                
            },
            textShadow: {
                sm: '1px 1px 2px rgba(0, 0, 0, 0.5)',
                DEFAULT: '2px 2px 4px rgba(0, 0, 0, 0.5)',
                lg: '3px 3px 6px rgba(0, 0, 0, 0.5)',
            },
        },
    },
    plugins: [
        function ({ addUtilities }) {
            addUtilities({
                '.text-shadow-sm': {
                    textShadow: '1px 1px 2px rgba(0, 0, 0, 0.5)',
                },
                '.text-shadow': {
                    textShadow: '2px 2px 4px rgba(0, 0, 0, 0.5)',
                },
                '.text-shadow-lg': {
                    textShadow: '3px 3px 6px rgba(0, 0, 0, 0.5)',
                },
            });
        },
    ],
};
