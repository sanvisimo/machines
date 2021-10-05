let mix = require('laravel-mix')

mix
  .setPublicPath('dist')
  .js('resources/js/aPanels.js', 'js')
  .sass('resources/sass/aPanels.scss', 'css')
