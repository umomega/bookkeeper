let mix = require('laravel-mix');

var assetsPath = 'resources/',
    publicPath = 'public/assets/bookkeeper/';

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

mix.js(assetsPath + 'js/app.js', publicPath + 'js')
   .js(assetsPath + 'js/updater.js', publicPath + 'js')
   .js(assetsPath + 'js/charts.js', publicPath + 'js')
   .sass(assetsPath + 'sass/app.scss', publicPath + 'css');
