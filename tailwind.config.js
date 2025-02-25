/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ["./app/views/**/*.phtml"],
  safelist: [
    'alert-success',
    'alert-danger',
    'active-btn'
  ],
  theme: 
  {
    extend: 
    {
      colors:
      {
        'primary': '#774972',
        'secondary': '#494977',
        'tertiary': '#DCDCDC'
      },
      fontFamily: 
      {
        'ws': ['Work Sans', 'sans-serif']
      }
    },
  },
  plugins: [],
}

