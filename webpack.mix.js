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

mix.js('resources/js/app.js', 'public/admin/js/core.js')
    .js('resources/js/admin/auth/auth.js', 'public/admin/js')
    .js('resources/js/admin/dashboard/dashboard.js', 'public/admin/js')
    .js('resources/js/admin/user/user.js', 'public/admin/js')
    .js('resources/js/admin/system-admin/admin.js', 'public/admin/js')
    .js('resources/js/admin/organization/organization.js', 'public/admin/js')
    .js('resources/js/admin/facility/facility.js', 'public/admin/js')
    .js('resources/js/admin/location/location.js', 'public/admin/js')
    .js('resources/js/admin/page/page.js', 'public/admin/js')
    .js('resources/js/admin/ui/ui.js', 'public/admin/js')
    .sass('resources/sass/app.scss', 'public/admin/css');
    mix.browserSync({
        proxy: 'startbox.loc.com',
    });
