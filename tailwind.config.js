/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ["./**/*.php"],
  theme: {
    extend: {
      colors: {
        primary: 'var(--ast-global-color-0)',
        secondary: 'var(--ast-global-color-4)',
      },
    },
  },
  plugins: [],
}
