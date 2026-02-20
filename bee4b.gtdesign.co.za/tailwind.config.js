const defaultTheme = require('tailwindcss/defaultTheme');

module.exports = {
    darkMode: 'class',
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './vendor/laravel/jetstream/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Inter'],
                // sans: ['SF Pro Display', 'sans-serif'],
            },
            colors: {
                'primary': {
                    light: '#5c80ef',
                    normal: 'rgb(54,97,235)',
                    dark: '#2c4cbb'
                },
                'b4bpurple': {
                  light: '#2E2C4C',
                  normal: 'rgb(46,44,76)',
                  dark: '#2E2C4C'
                },
                'b4bgreen': {
                  light: '#9DC43A',
                  normal: 'rgb(157,196,58)',
                  dark: '#9DC43A'
                }
            },
            backgroundImage: {
              'background': "url({{asset('/assets/logo/Login_Background.png')}})"
            }
        },
    },

    plugins: [
        require('@tailwindcss/forms'), 
        require('@tailwindcss/typography'),
        function({ addBase, theme }) {
            function extractColorVars(colorObj, colorGroup = '') {
              return Object.keys(colorObj).reduce((vars, colorKey) => {
                const value = colorObj[colorKey];
      
                const newVars =
                  typeof value === 'string'
                    ? { [`--color${colorGroup}-${colorKey}`]: value }
                    : extractColorVars(value, `-${colorKey}`);
      
                return { ...vars, ...newVars };
              }, {});
            }
      
            addBase({
              ':root': extractColorVars(theme('colors')),
            });
          },
    ],
};
