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

mix.js('resources/assets/js/app.js', 'public/assets/js').vue({ version: 2 })
    .sass('resources/assets/sass/app.scss', 'public/assets/css');

mix.js('resources/assets/admin/js/app.js', 'public/assets/admin/js').vue({ version: 2 })
    .js('resources/assets/admin/js/ckeditor.js', 'public/assets/admin/js')
    .sass('resources/assets/admin/sass/app.scss', 'public/assets/admin/css')
;

// mix.browserSync({
//     proxy: 'atg.dev',
//     files: [
//         'public/assets/**/*.css',
//         'public/assets/**/*.js',
//         'resources/views/**/*.php',
//     ]
// });
