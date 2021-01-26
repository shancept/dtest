module.exports = {
  plugins: {
    autoprefixer: {}
  },
  module: {
    // `module.rules` тоже самое, что и `module.loaders` в 1.x
    rules: [
      {
        test: /\.vue$/,
        loader: 'vue-loader',
        // настройки vue-loader
      }
    ]
  }
}
