const mix = require('laravel-mix');

mix.js(__dirname + '/Resources/assets/js/app.js', 'public/js')
    .sass(__dirname + '/Resources/assets/sass/app.scss', 'public/css');