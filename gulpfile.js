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


elixir(function(mix) {

    this.config.assetsPath = 'public/';
    //this.config.css.sass.folder = 'public/';
    //mix.stylesIn('public/');


    /*
     Styles that is in all templates
     */

    mix.styles([
    'assets/css/bootstrap.css',
    'assets/css/metisMenu.css',
    'assets/css/font-awesome.css',
    'assets/css/elegant-icons.css',
    'assets/css/pe-7-icons.css',
    'assets/css/pe-7-icons-helper.css',
    'assets/css/jquery-data-tables.css',
    'assets/css/jquery-data-tables-bs3.css',
    'assets/css/bootstrap3-wysihtml5.css',
    'assets/css/icheck-minimal.css',
    'assets/css/tether-shepherd.css',
    'assets/css/styles.css',
    ], 'public/assets/gulp/dashboard-styles.css', 'public/')

        .scripts([
    'assets/js/jquery.js',
    'assets/js/bootstrap.js',
    'assets/js/metisMenu.js',
    'assets/js/imagesloaded.js',
    'assets/js/masonry.js',
    'assets/js/pace.js',
    'assets/js/bootstrap3-wysihtml5.js',
    'assets/js/icheck.js',
    'assets/js/tether.js',
    'assets/js/tether-shepherd.js',
    'assets/js/main.js',
    'assets/js/notify.js',
    'assets/js/notifyjs-theme.js',

    ], 'public/assets/gulp/dashboard-scripts.js', 'public/')

        .version(['public/assets/gulp/dashboard-styles.css', 'public/assets/gulp/dashboard-scripts.js']);






    /*
     Styles that is in all templates
     */

   /* mix.styles([
    'frontend/css/plugins/owl-carousel/owl.carousel.min.css',
    'frontend/css/plugins/owl-carousel/owl.theme.default.min.css',
    'frontend/css/plugins/owl-carousel/owl.carousel.custom.css',
    'frontend/css/plugins/devices/devices.min.css',
    'frontend/css/font-awesome.css',
    'frontend/css/simple-line-icons.css',
    'frontend/css/plugins/magnific-popup/magnific-popup.css',
    'frontend/css/plugins/aos/aos.css',
    'frontend/css/plugins/loaders-css/loaders.min.css',
    'frontend/css/main.css',
    'frontend/css/themes/theme-blue.css',
    'frontend/css/custom.css',
    ], 'public/assets/gulp/frontend-styles.css', 'public/')

        .scripts([
    'frontend/js/jquery.min.js',
    'frontend/js/bootstrap.min.js',
    'frontend/js/plugins/classie/classie.js',
    'frontend/js/plugins/owl-carousel/owl.carousel.min.js',
    'frontend/js/plugins/isotope/isotope.pkgd.min.js',
    'frontend/js/plugins/magnific-popup/jquery.magnific-popup.min.js',
    'frontend/js/plugins/modernizr/modernizr-custom.js',
    'frontend/js/plugins/aos/aos.js',
    'frontend/js/plugins/jquery-validate/jquery.validate.min.js',
    'frontend/js/plugins/loaders-css/loaders.css.js',
    'frontend/js/main.js',

        ], 'public/assets/gulp/frontend-scripts.js', 'public/')

        .version(['public/assets/gulp/frontend-styles.css', 'public/assets/gulp/frontend-scripts.js']);*/
});
