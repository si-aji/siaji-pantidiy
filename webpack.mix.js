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
    // Fontawesome
    'resources/assets/adminlte/plugins/fontawesome-free/css/all.css'
], 'public/adminlte/plugins/fontawesome-free/css/all.css').version();
mix.styles([
    // Overlay Scrollbar
    'resources/assets/adminlte/plugins/overlayScrollbars/css/OverlayScrollbars.css'
], 'public/adminlte/plugins/overlayScrollbars/css/OverlayScrollbars.css').version();
mix.styles([
    // Datatable
    'resources/assets/adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.css'
], 'public/adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.css').version();
mix.styles([
    // Select2
    'resources/assets/adminlte/plugins/select2/css/select2.min.css'
], 'public/adminlte/plugins/select2/css/select2.min.css').version();
mix.styles([
    // Select2
    'resources/assets/adminlte/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css'
], 'public/adminlte/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css').version();
mix.styles([
    // Summernote
    'resources/assets/adminlte/plugins/summernote/summernote-bs4.css'
], 'public/adminlte/plugins/summernote/summernote-bs4.css').version();
mix.styles([
    // Tempus Dominus
    'resources/assets/adminlte/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css'
], 'public/adminlte/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css').version();

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
    // jQuery
    'resources/assets/adminlte/plugins/jquery/jquery.js'
], 'public/adminlte/plugins/jquery/jquery.js').version();
mix.scripts([
    // Bootstrap
    'resources/assets/adminlte/plugins/bootstrap/js/bootstrap.bundle.js'
], 'public/adminlte/plugins/bootstrap/js/bootstrap.bundle.js').version();
mix.scripts([
    // Overlay Scrollbar
    'resources/assets/adminlte/plugins/overlayScrollbars/js/jquery.overlayScrollbars.js'
], 'public/adminlte/plugins/overlayScrollbars/js/jquery.overlayScrollbars.js').version();
mix.scripts([
    // Datatable
    'resources/assets/adminlte/plugins/datatables/jquery.dataTables.js'
], 'public/adminlte/plugins/datatables/jquery.dataTables.js').version();
mix.scripts([
    // Datatable
    'resources/assets/adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.js'
], 'public/adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.js').version();
mix.scripts([
    // Custom File Input
    'resources/assets/adminlte/plugins/bs-custom-file-input/bs-custom-file-input.min.js'
], 'public/adminlte/plugins/bs-custom-file-input/bs-custom-file-input.min.js').version();
mix.scripts([
    // Select2
    'resources/assets/adminlte/plugins/select2/js/select2.full.min.js'
], 'public/adminlte/plugins/select2/js/select2.full.min.js').version();
mix.scripts([
    // Summernote
    'resources/assets/adminlte/plugins/summernote/summernote-bs4.min.js'
], 'public/adminlte/plugins/summernote/summernote-bs4.min.js').version();
mix.scripts([
    // Tempus Dominus
    'resources/assets/adminlte/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js'
], 'public/adminlte/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js').version();