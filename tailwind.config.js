module.exports = {
  content: ['./app/*.{php,js}', './app/**/*.{php,js}', './app/**/**/*.{php,js}'],
  daisyui: {
    themes: [
      {
        def: {        
          "primary": "#F54D2F",
          "secondary": "#0B3C33",
          "accent": "#B2E6C2",
          "neutral": "#E6D3C5",
          "base-100": "#FFFFFF",
          },
        },
      ],
    },
  plugins: [
    require('daisyui')
  ]
}