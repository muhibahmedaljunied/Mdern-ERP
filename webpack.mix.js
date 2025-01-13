const mix = require("laravel-mix");

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

// ---------------------------------------------------------------------------
//  <script src="{{URL::asset('assets/plugins/jquery/jquery.min.js')}}" defer></script>
// <script src="{{URL::asset('assets/js/jstree.js')}}" defer></script>
// <script src="{{URL::asset('assets/plugins/bootstrap/js/bootstrap.bundle.min.js')}}" defer></script>
// <script src="{{URL::asset('assets/plugins/ionicons/ionicons.js')}}" defer></script>
// <script src="{{URL::asset('assets/plugins/moment/moment.js')}}" defer></script>
// <script src="{{URL::asset('assets/plugins/rating/jquery.rating-stars.js')}}" defer></script>
// <script src="{{URL::asset('assets/plugins/rating/jquery.barrating.js')}}" defer></script>
// <script src="{{URL::asset('assets/plugins/perfect-scrollbar/perfect-scrollbar.min.js')}}" defer></script>
// <script src="{{URL::asset('assets/plugins/perfect-scrollbar/p-scroll.js')}}" defer></script>
// <script src="{{URL::asset('assets/plugins/jquery-sparkline/jquery.sparkline.min.js')}}" defer></script>
// <script src="{{URL::asset('assets/plugins/mscrollbar/jquery.mCustomScrollbar.concat.min.js')}}" defer></script>
// <script src="{{URL::asset('assets/plugins/sidebar/sidebar-rtl.js')}}" defer></script>
// <script src="{{URL::asset('assets/plugins/sidebar/sidebar-custom.js')}}" defer></script>
// <script src="{{URL::asset('assets/js/eva-icons.min.js')}}" defer></script>
// <script src="{{URL::asset('assets/js/sticky.js')}}" defer></script>
// <script src="{{URL::asset('assets/js/custom.js')}}" defer></script>
// <script src="{{URL::asset('assets/plugins/side-menu/sidemenu.js')}}" defer></script>
// ------------------------------------------------------------------------------------

/* <link href="{{URL::asset('assets/css/custom-search.css')}}" rel="stylesheet">  1
<link href="{{URL::asset('assets/css/font-awesome.min.css')}}" rel="stylesheet">2
<link rel="stylesheet" href="{{URL::asset('assets/css/jstree.css')}}" >3
<link href="{{URL::asset('assets/css/jquery-ui.min.css')}}" rel="stylesheet">4
<link rel="icon" href="{{URL::asset('assets/img/brand/favicon.png')}}" type="image/x-icon"/>
<link href="{{URL::asset('assets/css/icons.css')}}" rel="stylesheet">5
<link href="{{URL::asset('assets/css/estilos_factura.css')}}" rel="stylesheet">6
<link href="{{URL::asset('assets/plugins/mscrollbar/jquery.mCustomScrollbar.css')}}" rel="stylesheet"/>
<link href="{{URL::asset('assets/plugins/sidebar/sidebar.css')}}" rel="stylesheet">                   
<link rel="stylesheet" href="{{URL::asset('assets/css-rtl/sidemenu.css')}}">7
<link href="{{URL::asset('assets/css-rtl/style.css')}}" rel="stylesheet">8
<link href="{{URL::asset('assets/css-rtl/style-dark.css')}}" rel="stylesheet">9
<link href="{{URL::asset('assets/css-rtl/skin-modes.css')}}" rel="stylesheet">10
<link href="{{URL::asset('assets/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
</link> */

// -----------------------------
//  C:\xampp\htdocs\ERP\assets\plugins\jquery\jquery.min.js
// C:\xampp\htdocs\ERP\assets\plugins\bootstrap\js\bootstrap.bundle.min.js
// C:\xampp\htdocs\ERP\assets\plugins\ionicons\ionicons.js
// C:\xampp\htdocs\ERP\assets\plugins\moment\moment.js
// C:\xampp\htdocs\ERP\assets\plugins\rating\jquery.rating-stars.js
// C:\xampp\htdocs\ERP\assets\plugins\rating\jquery.barrating.js
// C:\xampp\htdocs\ERP\assets\plugins\perfect-scrollbar\perfect-scrollbar.min.js
// C:\xampp\htdocs\ERP\assets\plugins\perfect-scrollbar\p-scroll.js
// C:\xampp\htdocs\ERP\assets\plugins\jquery-sparkline\jquery.sparkline.min.js
// C:\xampp\htdocs\ERP\assets\plugins\mscrollbar\jquery.mCustomScrollbar.concat.min.js
// C:\xampp\htdocs\ERP\assets\plugins\sidebar\sidebar-rtl.js
// C:\xampp\htdocs\ERP\assets\plugins\sidebar\sidebar-custom.js
// C:\xampp\htdocs\ERP\assets\js\eva-icons.min.js
// C:\xampp\htdocs\ERP\assets\js\sticky.js
// C:\xampp\htdocs\ERP\assets\js\custom.js
// C:\xampp\htdocs\ERP\assets\plugins\side-menu\sidemenu.js

mix.js(
    [
        // --------------------------------------------------------------------------------------------------------
        "resources/js/app.js",
        // "resources/js/accordion.js",
        // "resources/js/advanced-form-elements.js",
        // "resources/js/apexcharts.js",
        // "resources/js/app-calendar-events.js",
        // "resources/js/app-calendar.js",
        // "resources/js/bootstrap.min.js",
        // "resources/js/carousel.js",
        // "resources/js/chart.chartjs.js",
        // "resources/js/chart.flot.js",

        // ---------------------------------------------
        // "resources/js/jquery.min.js",
        // "resources/js/bootstrap.bundle.min.js",
        // "resources/js/ionicons.js",
        // "resources/js/moment.js",
        // "resources/js/jquery.rating-stars.js",
        // "resources/js/jquery.barrating.js",
        // "resources/js/perfect-scrollbar.min.js",
        // "resources/js/p-scroll.js",
        // "resources/js/jquery.sparkline.min.js",
        // "resources/js/jquery.mCustomScrollbar.concat.min.js",
        // "resources/js/sidebar-rtl.js",
        // "resources/js/sidebar-custom.js",
        // "resources/js/eva-icons.min.js",
        // "resources/js/esticky.js",
        // "resources/js/custom.js",
        // "resources/js/sidemenu.js",
    ],
    "js/app.js"
).sass("resources/sass/app.scss", "css");
// .styles(
//     [
//         // ---------------------------resources/css/css-------------------------------
//         // "resources/css/animate.css",
//         // "resources/css/bootstrap3.3.6.min.css",
//         // "resources/css/custom-search.css",
//         // "resources/css/estilos_factura.css",
//         // "resources/css/font-awesome.min.css",
//         // "resources/css/icons.css",
//         // "resources/css/jquery-ui.min.css",
//         // "resources/css/jstree.css",
//         // "resources/css/opensans-font.css",
//         // "resources/css/roboto-font.css",
//         // "resources/css/sidemenu.css",
//         // "resources/css/sidemenu.css.map",
//         // "resources/css/sidemenu.scss",
//         // "resources/css/skin-modes.css",
//         // "resources/css/style copy.css",
//         // "resources/css/style-dark.css",
//         // "resources/css/style-dark.css.map",
//         // "resources/css/style.css",
//         // -------------------------------------resources/css/css-rtl---------------------
//         // "resources/css/css-rtl/animate.css",
//         // "resources/css/css-rtl/icons.css",
//         // "resources/css/css-rtl/sidemenu.css",
//         // "resources/css/css-rtl/skin-modes.css",
//         // "resources/css/css-rtl/skin-modes.scss",
//         // "resources/css/css-rtl/style-dark.css",
//         // "resources/css/css-rtl/style.css",
//     ],
//     "css/app.css"
// );

// mix.js('resources/js/app.js', 'js')
//     .sass('resources/sass/app.scss', 'css');
