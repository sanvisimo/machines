let mix = require('laravel-mix')

mix.setPublicPath('dist')
    .js('resources/js/aPanels.js', 'js').vue()
    .postCss('resources/css/aPanels.css', 'css')
