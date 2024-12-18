/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ["./app/views/**/*.phtml"],
  safelist: [
    'alert-success',
    'alert-danger'
  ],
  theme: 
  {
    extend: 
    {
      colors:
      {
        'bg-primary': '#774972',
        'bg-secondary': '#6a4731',
        'primary': '#774972',
        'secondary': '#6a4731',
        'tertiary': '#8E5C3C'
      },
      fontFamily: 
      {
        'ws': 'Work Sans'
      }
    },
  },
  plugins: [],
}

