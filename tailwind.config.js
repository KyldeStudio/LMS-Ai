// tailwind.config.js
plugins: [
  function({ addComponents }) {
    addComponents({
      '.btn': {
        '@apply inline-flex items-center justify-center px-4 py-2 rounded-md bg-blue-600 text-white hover:bg-blue-700 transition': {},
      },
    })
  }
]

/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ["./dist/**/*.{html,js}"],
  theme: {
    extend: {},
  },
  plugins: [],
};
    