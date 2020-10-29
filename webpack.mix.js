const mix = require('laravel-mix');

mix.js('resources/js/app.js', 'public/js')
    .js('resources/js/admin.js', 'public/js')
    .sass('resources/css/app.scss', 'public/css')
    .sass('resources/css/home.scss', 'public/css');