let mix = require('laravel-mix')

mix
  .setPublicPath('dist')
  .js('resources/js/field.js', 'js')
  .sass('resources/css/field.scss', 'css')
