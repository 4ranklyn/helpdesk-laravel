/** @type {import('tailwindcss').Config} */
import colors from 'tailwindcss/colors'
import forms from '@tailwindcss/forms'
import typography from '@tailwindcss/typography'

export default {
  content: [
      './resources/**/*.blade.php',
      './vendor/filament/**/*.blade.php',
  ],
  darkMode: 'class',
  theme: {
    extend: {
      colors: {
        danger: colors.rose,
        primary: colors.blue,
        success: colors.green,
        warning: colors.yellow,
        gray: {
            ...colors.gray, // <-- Ambil semua nilai gray bawaan
            '100': '#0066ffff', // <-- Timpa HANYA nilai 100 dengan kodemu
        }
      },
    },
  },
  plugins: [
      forms,
      typography,
  ],
}

