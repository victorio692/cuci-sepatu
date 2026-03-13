/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    // All PHP files in app directory
    './app/**/*.php',
    './app/**/*.html',
    // All HTML/PHP in public
    './public/**/*.php', 
    './public/**/*.html',
    // Top level PHP files
    './*.php',
    './*.html',
  ],
  theme: {
    extend: {
      colors: {
        primary: '#3b82f6',
        secondary: '#2563eb',
      }
    },
  },
  plugins: [],
}
