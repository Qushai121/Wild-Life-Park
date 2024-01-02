/** @type {import('tailwindcss').Config} */

module.exports = {
  darkMode: "class",
  content: [
    'app/Views/**/*.php'
  ],
  theme: {
    extend: {
      animation: {
        'horizontal-shaking': 'horizontal-shaking 0.5s ease-in-out 1s',
      },
      colors: {
        greenMain: "#007f38",
        greenSecond: "#00ff71",
        greenThird: "#7fffb8",
      },
      boxShadow: {
        'rounded-2': '0px 10px 1px rgba(221, 221, 221, 1), 0 10px 20px rgba(204, 204, 204, 1)',
      },
    },
  },
  plugins: [
    require("daisyui"),
    require('tailwind-scrollbar')
  ],
}

