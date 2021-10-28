let mix = require('laravel-mix')

mix.setPublicPath('dist')
    .js('resources/js/accordion.js', 'js').vue()
    .postCss('resources/css/Accordion.css', 'css')
