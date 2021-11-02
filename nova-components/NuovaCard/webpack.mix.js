let mix = require('laravel-mix')

mix
  .setPublicPath('dist')
  .js('resources/js/card.js', 'js').vue()
  .postCss('resources/css/card.css', 'css')
