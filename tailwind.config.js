/** @type {import('tailwindcss').Config} */
export default {
    content: [
      "./resources/**/*.blade.php",
      "./resources/**/*.js",
      "./resources/**/*.vue",
    ],
    theme: {
      extend: {
        colors: {
          'museum-red': '#8b1c1c', 
          'museum-bg': '#fcfcfc',
        },
        fontFamily: {
          'serif': ['"Playfair Display"', 'Georgia', 'serif'], 
          'sans': ['Inter', 'ui-sans-serif', 'system-ui'],
        }
      },
    },
    plugins: [],
  }
