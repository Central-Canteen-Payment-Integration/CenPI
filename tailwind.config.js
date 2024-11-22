module.exports = {
  content: ['./app/*.{php,js}', './app/**/*.{php,js}'],
  daisyui: {
    themes: ["autumn", "dim"]
  },
  plugins: [
    require('daisyui')
  ]
}