/** @type {import('tailwindcss').Config} */
module.exports = {
  content:[
    // Use *.tsx if using TypeScript
    './pages/**/*.js',
    './components/**/*.js'
  ],
  theme: {
    extend: {
      colors: {
        ojgreen: '#10aab0',
        ojblack: '#2c2c2c',
        ojwhite: '#f4f4f4',
      },
      textShadow: {
        'white-lg': '3px 3px 6px rgb(255 255 255 / 26%), 0 0 5px rgb(255 255 255 / 22%)',
      },
    },    
  },
  variants: {
    extend: {
      fontWeight: ['hover', 'focus', 'active'],
    },
  },
  plugins: [
    require('tailwindcss-textshadow')
  ],
}
