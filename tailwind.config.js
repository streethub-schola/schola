/** @type {import('tailwindcss').Config} */

module.exports = {
  content: [
    "./public/**/*.{html,js}",
],
  theme: {
    extend: {
      colors: {
        'regal-blue': '#243c5a',
      },
    },
  },
  plugins: [],
  darkMode: "class"
}

