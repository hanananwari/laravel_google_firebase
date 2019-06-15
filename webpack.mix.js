
let mix = require('laravel-mix');

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

// plugins 

mix.scripts(['Solumax/GoogleFirebase/Resources/Plugins/app.js', 'Solumax/GoogleFirebase/Resources/Plugins/**/*.js'], 'public/plugins/all.js');
mix.copy('Solumax/GoogleFirebase/Resources/Plugins', 'Public/Plugins');


