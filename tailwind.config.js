const defaultTheme = require('tailwindcss/defaultTheme')
const plugin = require('tailwindcss/plugin')
const Color = require('color')

module.exports = {
  darkMode: 'class',
  purge: [
    './resources/**/*.blade.php',
    './resources/**/*.js',
    './public/**/*.html',
  ],
  theme: {
    extend: {
      screens: {
        'xs': '425px',
      },
      colors: {
        primary: '#23925C',
        secondary: '#1D6944',
        transparent: 'transparent',
        white: '#ffffff',
        black: '#000000',
      },
      fontFamily: {
        sans: ['Open Sans', ...defaultTheme.fontFamily.sans],
      },
    },
  },
  plugins: [
    require('@tailwindcss/forms'),
    require('@tailwindcss/line-clamp'),
    plugin(({ addUtilities, e, theme, variants }) => {
      const newUtilities = {}
      Object.entries(theme('colors')).map(([name, value]) => {
        if (name === 'transparent' || name === 'current') return
        const color = value[300] ? value[300] : value
        const hsla = Color(color).alpha(0.45).hsl().string()

        newUtilities[`.shadow-outline-${name}`] = {
          'box-shadow': `0 0 0 3px ${hsla}`,
        }
      })

      addUtilities(newUtilities, variants('boxShadow'))
    }),
  ],
}
