const mix = require('laravel-mix');

mix.js('resources/js/app.js', 'dist/js')
    .sass('resources/sass/app.scss', 'dist/css')
    .setPublicPath('dist');  // Define o diretório de saída como 'dist'
