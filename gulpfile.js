var elixir = require('laravel-elixir');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir(function (mix) {
    mix.sass('app.scss');
    mix.sass('bootstrap.scss');

    mix.styles([
        'resources/vendor/components-font-awesome/css/font-awesome.min.css',
        'public/css/bootstrap.css',
        'public/css/app.css'
    ], 'public/css/app.css', './');

    mix.scripts([
        'resources/vendor/jquery/dist/jquery.min.js',
        'resources/vendor/bootstrap-sass/assets/javascripts/bootstrap.min.js',
        'resources/assets/js/common.js'
    ], 'public/js/app.js', './');

    mix.copy('resources/vendor/components-font-awesome/fonts', 'public/build/fonts');
    mix.copy('resources/vendor/bootstrap-sass/assets/fonts/', 'public/build/fonts');

    mix.version(['css/app.css', 'js/app.js']);
});
