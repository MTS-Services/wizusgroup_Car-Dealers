/** @type {import('tailwindcss').Config} */

const defaultTheme = require('tailwindcss/defaultTheme');

module.exports = {
  content: [
    './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
    './storage/framework/views/*.php',
    './resources/**/*.blade.php',
    './resources/**/*.js',
    './resources/**/*.vue',
    '*'
  ],
  darkMode: 'class',

  theme: {
    container: {
      center: true,
      padding: '1rem',
      screens: {
        '3xl': '1536px',
      }
    },
    extend: {
      screens: {
        'xs': '480px',
        'sm': '512px',
        'md': '640px',
        'lg': '768px',
        'xl': '1024px',
        '2xl': '1200px',
        '3xl': '1536px',
      },
      colors: {
        // Utility Tokens (Semantic Usage)
        text: {
          primary: '#181C14',
          secondary: '#0972C1',
          tertiary: '#422AD5',

          light: '#F2F9FF',
          'light-secondary': '#FBFBFB',

          'dark': '#030303',
          'dark-secondary': '#FBFBFB',

          white: '#ffffff',
          black: '#000000',
          danger: '#DC2626',
          orange: "#ff6b6b",
        },

        bg: {
          primary: '#0972C1',
          secondary: '#FBFBFB',
          tertiary: '#422AD5',

          light: '#F2F9FF',
          'light-secondary': '#FBFBFB',

          'dark': '#030303',
          'dark-secondary': '#0F0F0F',
          'dark-tertiary': '#1F1F1F',

          white: '#ffffff',
          black: '#000000',
          danger: '#DC2626',
          orange: "#ff6b6b",
        },

        border: {
          primary: '#0972C1',
          secondary: '#FBFBFB',
          tertiary: '#422AD5',
          gray: '#F2F2F2',

          light: '#F2F9FF',
          'light-secondary': '#FBFBFB',

          'dark': '#030303',
          'dark-secondary': '#FBFBFB',

          white: '#ffffff',
          black: '#000000',
          danger: '#DC2626',
          orange: "#ff6b6b",
        },

        outline: {
          primary: '#0972C1',
          secondary: '#FBFBFB',
          tertiary: '#422AD5',

          light: '#F2F9FF',
          'light-secondary': '#FBFBFB',

          'dark': '#030303',
          'dark-secondary': '#FBFBFB',

          white: '#ffffff',
          black: '#000000',
          danger: '#DC2626',
          orange: "#ff6b6b",
        },

        focus: {
          primary: '#0972C1',
          secondary: '#FBFBFB',
          tertiary: '#422AD5',

          light: '#F2F9FF',
          'light-secondary': '#FBFBFB',

          'dark': '#030303',
          'dark-secondary': '#FBFBFB',

          white: '#ffffff',
          black: '#000000',
          danger: '#DC2626',
          orange: "#ff6b6b",
        },

        shadow: {
          primary: '#0972C1',
          secondary: '#FBFBFB',
          tertiary: '#422AD5',

          light: '#F2F9FF',
          'light-secondary': '#FBFBFB',

          'dark': '#030303',
          'dark-secondary': '#FBFBFB',

          white: '#ffffff',
          black: '#000000',
          danger: '#DC2626',
          orange: "#ff6b6b",
        }
      },
      fontFamily: {
        'inter': ['Inter', ...defaultTheme.fontFamily.sans],
        'poppins': ['Poppins', ...defaultTheme.fontFamily.sans],
        'display': ['Playfair Display', ...defaultTheme.fontFamily.serif],
      },
      fontSize: {
        'xs': ['0.75rem', { lineHeight: '1rem' }],         // 12px
        'sm': ['0.875rem', { lineHeight: '1.25rem' }],     // 14px
        'base': ['1rem', { lineHeight: '1.5rem' }],        // 16px
        'lg': ['1.125rem', { lineHeight: '1.75rem' }],     // 18px
        'xl': ['1.25rem', { lineHeight: '1.75rem' }],      // 20px
        '2xl': ['1.5rem', { lineHeight: '2rem' }],         // 24px
        '3xl': ['1.875rem', { lineHeight: '2.25rem' }],    // 30px
        '4xl': ['2.25rem', { lineHeight: '2.5rem' }],      // 36px
        '5xl': ['3rem', { lineHeight: '1' }],              // 48px
        '6xl': ['3.75rem', { lineHeight: '1' }],           // 60px
        '7xl': ['4.5rem', { lineHeight: '1' }],            // 72px
        '8xl': ['6rem', { lineHeight: '1' }],              // 96px
        '9xl': ['8rem', { lineHeight: '1' }],              // 128px
      },
      spacing: {
        '4.5': '1.125rem',  // 18px
        '13': '3.25rem',    // 52px
        '15': '3.75rem',    // 60px
        '18': '4.5rem',     // 72px
        '22': '5.5rem',     // 88px
        '26': '6.5rem',     // 104px
        '30': '7.5rem',     // 120px
      },
      boxShadow: {
        'sm': '0 1px 2px 0 rgba(0, 0, 0, 0.05)',
        'DEFAULT': '0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06)',
        'md': '0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06)',
        'lg': '0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05)',
        'xl': '0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04)',
        '2xl': '0 25px 50px -12px rgba(0, 0, 0, 0.25)',
        'card': '0px 1px 2px rgba(0, 0, 0, 0.06), 0px 1px 3px rgba(0, 0, 0, 0.1)',
        'dropdown': '0px 10px 15px -3px rgba(0, 0, 0, 0.1), 0px 4px 6px -2px rgba(0, 0, 0, 0.05)',
        'inner': 'inset 0 2px 4px 0 rgba(0, 0, 0, 0.06)',
        'shadowPrimary': 'rgba(99, 99, 99, 0.2) 0px 2px 8px 0px',
      },
      borderRadius: {
        'none': '0',
        'sm': '0.125rem',     // 2px
        'DEFAULT': '0.25rem',  // 4px
        'md': '0.375rem',      // 6px
        'lg': '0.5rem',        // 8px
        'xl': '0.75rem',       // 12px
        '2xl': '1rem',         // 16px
        '3xl': '1.5rem',       // 24px
        'full': '9999px',
      },
      backgroundImage: {
        'gradient-primary': 'linear-gradient(45deg, #4CAF83 0%, #86BD59 100%)',
        'gradient-secondary': 'linear-gradient(45deg, #FFCA40 0%, #FDC040 100%)',
        'gradient-light': 'linear-gradient(45deg, #EFEFFE 0%, #FFEFF6 100%)',
        'gradient-dark': 'linear-gradient(45deg, #2E2E4D 0%, #4D2E3C 100%)',
        'star': 'radial-gradient(circle, rgba(255, 255, 255, 0.8), transparent)',
        'nav-border': 'linear-gradient( to bottom,  red,  rgba(0, 0, 0, 0) ) 1 100%',

        // linear-gradient( to bottom,  red,  rgba(0, 0, 0, 0) ) 1 100%;
      },
      animation: {
        'fade-in': 'fadeIn 0.3s ease-in-out',
        'slide-up': 'slideUp 0.3s ease-in-out',
        'slide-down': 'slideDown 0.3s ease-in-out',
        'starFade': 'starFade 0.6s ease-out forwards, rise-top-left 0.6s ease-out',
        'scalePulse': 'scalePulse 1s ease-in-out infinite',
        'dotRotate': 'dotRotate 2s linear infinite',
      },
      keyframes: {
        fadeIn: {
          '0%': { opacity: '0' },
          '100%': { opacity: '1' },
        },
        slideUp: {
          '0%': { transform: 'translateY(10px)', opacity: '0' },
          '100%': { transform: 'translateY(0)', opacity: '1' },
        },
        slideDown: {
          '0%': { transform: 'translateY(-10px)', opacity: '0' },
          '100%': { transform: 'translateY(0)', opacity: '1' },
        },
        'starFade': {
          '0%': { opacity: 0 },
          '100%': { opacity: 1 },
        },
        'scalePulse': {
          '0%': { transform: 'scale(1)' },
          '50%': { transform: 'scale(.8)' },
          '100%': { transform: 'scale(1)' },
        },
        'dotRotate': {
          '0%': { transform: 'translate(-50%, -50%) rotate(0deg)' },
          '100%': { transform: 'translate(-50%, -50%) rotate(360deg)' },
        },
      },
    },
  },
  plugins: [
    require('daisyui'),
  ],

}
