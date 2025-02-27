import defaultTheme from 'tailwindcss/defaultTheme';
import withMT from "@material-tailwind/html/utils/withMT";

/** @type {import('tailwindcss').Config} */
export default withMT({
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
                "title-gradient":
                  "linear-gradient(to bottom right, #51B2B8 0%, #155458 100%)",
                
            },
            textShadow: {
                sm: '1px 1px 2px rgba(0, 0, 0, 0.5)',
                DEFAULT: '2px 2px 4px rgba(0, 0, 0, 0.5)',
                lg: '3px 3px 6px rgba(0, 0, 0, 0.5)',
            },
            colors: {
                greenTheme: '#155458',
                FAFA : '#FAFAFA'
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
                '.text-stroke': {
                    '-webkit-text-stroke': '2px black',
                },
                '.text-stroke-white': {
                    '-webkit-text-stroke': '2px white',
                },
            });
        },
    ],
});
