const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/js/vendor/tooltip.js', 'public/js/vendors/')
    .js('resources/js/vendor/modal.js', 'public/js/vendors/')
   // .sass('resources/sass/app.scss', 'public/css');
mix.webpackConfig({
    externals: {
        "jquery": "jQuery"
    }
});
