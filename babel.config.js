module.exports = {
  plugins: [
    '@babel/plugin-transform-runtime'
  ],
  presets: [
    ['@babel/preset-env', {
      corejs: '3',
      useBuiltIns: 'usage'
    }]
  ]
}
