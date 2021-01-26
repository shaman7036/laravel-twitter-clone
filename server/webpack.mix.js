const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/js/app.js', 'public/js')
    .postCss('resources/css/app.css', 'public/css', [
        //
    ]);

mix // auth
    .sass('resources/sass/auth/auth.sass', '../resources/build')
    .sass('resources/sass/auth/auth_mobile.sass', '../resources/build')
    // dialogs
    .sass('resources/sass/dialogs/delete_dialog.sass', '../resources/build')
    .sass('resources/sass/dialogs/tweet_details_dialog.sass', '../resources/build')
    .sass('resources/sass/dialogs/tweet_dialog.sass', '../resources/build')
    .sass('resources/sass/dialogs/users_dialog.sass', '../resources/build')
    .sass('resources/sass/dialogs/dialog_mobile.sass', '../resources/build')
    // home
    .sass('resources/sass/home/home.sass', '../resources/build')
    .sass('resources/sass/home/home_mobile.sass', '../resources/build')
    .sass('resources/sass/home/right_user.sass', '../resources/build')
    .sass('resources/sass/home/timeline.sass', '../resources/build')
    // navigation
    .sass('resources/sass/navigation/navigation.sass', '../resources/build')
    .sass('resources/sass/navigation/navigation_mobile.sass', '../resources/build')
    .sass('resources/sass/navigation/search.sass', '../resources/build')
    .sass('resources/sass/navigation/menu.sass', '../resources/build')
    .styles(
        [
            // auth
            'resources/build/auth.css',
            'resources/build/auth_mobile.css',
            // dialogs
            'resources/build/delete_dialog.css',
            'resources/build/tweet_details_dialog.css',
            'resources/build/tweet_dialog.css',
            'resources/build/users_dialog.css',
            'resources/build/dialog_mobile.css',
            // home
            'resources/build/home.css',
            'resources/build/home_mobile.css',
            'resources/build/right_user.css',
            'resources/build/timeline.css',
            // navigation
            'resources/build/navigation.css',
            'resources/build/navigation_mobile.css',
            'resources/build/search.css',
            'resources/build/menu.css',
        ],
        'public/css/app.css'
    )
