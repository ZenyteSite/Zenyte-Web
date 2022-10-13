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

mix.sass('resources/sass/app.scss', 'public/css');

mix.copyDirectory('resources/css', 'public/css');
mix.copyDirectory('resources/img', 'public/img');
mix.copyDirectory('resources/fonts', 'public/fonts');
mix.copyDirectory('resources/js', 'public/js');
