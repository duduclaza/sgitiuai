/** @type {import('tailwindcss').Config} */
export default {
  content: [
    './index.html',
    './src/**/*.{js,jsx}',
  ],
  theme: {
    extend: {
      colors: {
        primary: {
          dark: '#1e3a8a',
          light: '#3b82f6',
        },
        secondary: {
          beige: '#d4c5a9',
          light: '#e8dcc8',
        }
      }
    },
  },
  plugins: [],
}
