process.env.DISABLE_NOTIFIER = true;
const elixir = require('laravel-elixir');


/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for your application as well as publishing vendor resources.
 |
 */

elixir((mix) => {
    mix.scriptsIn('Resources/Plugins/', 'Public/Plugins/all.js');
    mix.copy('Resources/Plugins', 'Public/Plugins');
});