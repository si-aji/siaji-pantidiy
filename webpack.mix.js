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

// AdminLTE CSS
mix.styles([
    'resources/assets/adminlte/css/adminlte.css'
], 'public/adminlte/css/adminlte.css').version();
// SIAJI CSS
mix.styles([
    'resources/assets/adminlte/css/siaji.css'
], 'public/adminlte/css/siaji.css').version();

// Plugin CSS
mix.styles([
    'resources/assets/adminlte/plugins/fontawesome-free/css/all.css'
], 'public/adminlte/plugins/fontawesome-free/css/all.css').version();
mix.styles([
    'resources/assets/adminlte/plugins/overlayScrollbars/css/OverlayScrollbars.css'
], 'public/adminlte/plugins/overlayScrollbars/css/OverlayScrollbars.css').version();
mix.styles([
    'resources/assets/adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.css'
], 'public/adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.css').version();

// AdminLTE Js
mix.scripts([
    'resources/assets/adminlte/js/adminlte.js'
], 'public/adminlte/js/adminlte.js').version();
// SIAJI Js
mix.scripts([
    'resources/assets/adminlte/js/siaji.js'
], 'public/adminlte/js/siaji.js').version();

// Plugins JS
mix.scripts([
    'resources/assets/adminlte/plugins/jquery/jquery.js'
], 'public/adminlte/plugins/jquery/jquery.js').version();
mix.scripts([
    'resources/assets/adminlte/plugins/bootstrap/js/bootstrap.bundle.js'
], 'public/adminlte/plugins/bootstrap/js/bootstrap.bundle.js').version();
mix.scripts([
    'resources/assets/adminlte/plugins/overlayScrollbars/js/jquery.overlayScrollbars.js'
], 'public/adminlte/plugins/overlayScrollbars/js/jquery.overlayScrollbars.js').version();
mix.scripts([
    'resources/assets/adminlte/plugins/datatables/jquery.dataTables.js'
], 'public/adminlte/plugins/datatables/jquery.dataTables.js').version();
mix.scripts([
    'resources/assets/adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.js'
], 'public/adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.js').version();
mix.scripts([
    'resources/assets/adminlte/plugins/bs-custom-file-input/bs-custom-file-input.min.js'
], 'public/adminlte/plugins/bs-custom-file-input/bs-custom-file-input.min.js').version();