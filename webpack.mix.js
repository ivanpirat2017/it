const mix = require('laravel-mix');


mix.js('resources/js/app.js', 'public/js').vue()
.sass('resources/sass/dark.scss', 'public/css')
.sass('resources/sass/light.scss', 'public/css')
.sass('resources/sass/app.scss', 'public/css')
