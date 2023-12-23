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
  plugins: [
    require("tw-elements/dist/plugin.cjs")
  ],
  darkMode: "class"
}

