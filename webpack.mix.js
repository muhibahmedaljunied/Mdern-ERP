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
mix.setPublicPath("/");
mix.js(
    [
        // "public/assets/plugins/jquery/jquery.min.js",
        // "public/assets/js/jstree.js",
        // "public/assets/plugins/ionicons/ionicons.js",
        // "public/assets/js/eva-icons.min.js",
        // -------------------------------------------------------------------------------------------------------------------
        "resources/js/app.js",
        // "public/assets/plugins/jquery/jquery.min.js",
        // "public/assets/js/jstree.js",
        // "public/assets/plugins/side-menu/sidemenu.js",
        // "public/assets/plugins/bootstrap/js/bootstrap.bundle.min.js",
        // "public/assets/plugins/ionicons/ionicons.js",
        // "public/assets/plugins/moment/moment.js",
        // "public/assets/plugins/rating/jquery.rating-stars.js",
        // "public/assets/plugins/rating/jquery.barrating.js",
        // "public/assets/plugins/perfect-scrollbar/perfect-scrollbar.min.js",
        // "public/assets/plugins/perfect-scrollbar/p-scroll.js",
        // "public/assets/plugins/jquery-sparkline/jquery.sparkline.min.js",
        // // "public/assets/plugins/mscrollbar/jquery.mCustomScrollbar.concat.min.js",
        // "public/assets/plugins/sidebar/sidebar-rtl.js",
        // "public/assets/plugins/sidebar/sidebar-custom.js",
        // "public/assets/js/eva-icons.min.js",
        // "public/assets/js/sticky.js",
        // "public/assets/js/custom.js",
        // -------------------------------------------------------------------------------------------------------------------
        // "public/assets/plugins/side-menu/sidemenu.js",
        // "public/assets/plugins/sidebar/sidebar-rtl.js",
        // "public/assets/plugins/sidebar/sidebar-custom.js",

        // ----------------------------------------------------------
        // "public/assets/plugins/side-menu/sidemenu.js",
        // "public/assets/js/script.js",
        // "public/assets/js/jquery.min.js",
        // "public/assets/js/bootstrap.min.js",
        // // "assetss/js/jquery-3.5.1.min.js",
        // // "assetss/js/popper.min.js",
        // // "assetss/js/bootstrap.min.js",
        // // "assetss/js/jquery.slimscroll.min.js",
        // // "assetss/js/select2.min.js",
        // // "assetss/js/moment.min.js",
        // // "assetss/js/bootstrap-datetimepicker.min.js",
    ],

    "js/app.js"
)
    // .sass("resources/sass/app.scss", "css");
    .styles(
        [
            // -----------------------------------------------------------------------------------------------------------------------------
            "assets/css/custom-search.css",
            "assets/css/font-awesome.min.css",
            "assets/css/jstree.css",
            "assets/css/jquery-ui.min.css",
            // 'public/assets/img/brand/favicon.png',
            // "public/assets/css/icons.css",
            // --------------------------------------------------------------------------------------------------------------------------------
            // "public/assets/plugins/fontawesome-free/css/all.min.css",
            // "public/assets/plugins/ionicons/css/ionicons.min.css",
            // "public/assets/plugins/typicons.font/typicons.css",
            // "public/assets/plugins/materialdesignicons/materialdesignicons.css",
            // "public/assets/plugins/themify/themify.css",
            // "public/assets/plugins/feather/feather.css",
            // "public/assets/plugins/cryptofont/css/cryptofont.min.css",
            // "public/assets/plugins/line-awesome/css/line-awesome.css",
            // "public/assets/plugins/simple-line-icons/simple-line-icons.css",
            // "public/assets/plugins/flag-icon-css/css/flag-icon.min.css",
            // "public/assets/plugins/boxicons/css/boxicons.css",
            // --------------------------------------------------------------------------------------------------------------------------------
            "assets/css/estilos_factura.css",
            "assets/plugins/mscrollbar/jquery.mCustomScrollbar.css",
            "assets/plugins/sidebar/sidebar.css",
            "assets/css-rtl/sidemenu.css",
            "assets/css-rtl/style.css",
            "assets/css-rtl/style-dark.css",
            "assets/css-rtl/skin-modes.css",
            "assets/bootstrap/css/bootstrap.min.css",
        ],
        "css/app.css"
    );

// mix.js("resources/js/app.js", "js").sass("resources/sass/app.scss", "css");
