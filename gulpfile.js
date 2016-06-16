var elixir = require("laravel-elixir");

elixir.config.sourcemaps = true;

elixir(function (mix) {

    var bowerAssetsDir = "resources/assets/bower/";

    // CLIENT SIDE LESS SCRIPTS
    mix.less(['main.less'], 'public/css/frontend');
    mix.less(['mail.less'], 'public/css/mail');

    // styles
    mix.styles([
        // bootstrap
        "bootswatch-dist/css/bootstrap.css",

        // animate
        "animate.css/animate.css",

        // bootstrap rating
        "bootstrap-rating/bootstrap-rating.css",

        // bootstrap table
        "bootstrap-table/dist/bootstrap-table.min.css",

        // swal
        "sweetalert/lib/sweet-alert.css",

        // datetime picker
        "eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.css",

        // font awesome
        "font-awesome/css/font-awesome.css",

        // form validation
        "formvalidation/dist/css/formValidation.css",

        // owl
        "owl.carousel/dist/assets/owl.carousel.css",
        "owl.carousel/dist/assets/owl.theme.default.css",

        // lightbox
        "lightbox2/dist/css/lightbox.css",

        // pace theme
        "pace/themes/white/pace-theme-flash.css",

        // select2
        "select2/select2.css"

    ], "public/css/frontend/libs.css", bowerAssetsDir);

    // ADMIN STYLES
    mix.less(['backend/backend.less'], 'public/css/backend');

    mix.less(['general.less'], 'public/css/backend');

    mix.styles([

        // summernote
        "summernote/dist/summernote.css",

        // data tables
        "datatables/media/css/jquery.dataTables.css"
        //"datatables-bootstrap3/BS3/assets/css/datatables.css"

    ], "public/css/backend/all.css", bowerAssetsDir);

    // FONTS
    mix.copy(bowerAssetsDir + 'font-awesome/fonts', 'public/css/fonts');

    mix.copy(bowerAssetsDir + 'bootstrap/fonts', 'public/css/fonts');

    mix.copy(bowerAssetsDir + 'datatables-bootstrap3/BS3/assets/images', 'public/css/images');

    // custom scripts
    mix.scriptsIn("resources/assets/js/custom", "public/js/frontend/main.js");

    // vendor scripts
    mix.scripts([
        // jquery
        "jquery/dist/jquery.js",

        // swal
        "sweetalert/lib/sweet-alert.js",

        // bootstrap
        "bootswatch-dist/js/bootstrap.min.js",

        // hover dropdown
        "bootstrap-hover-dropdown/bootstrap-hover-dropdown.js",

        // moment
        "moment/min/moment.min.js",

        // select2
        "select2/select2.js",

        // wow
        "WOW/dist/wow.min.js",

        // owl
        "owl.carousel/dist/owl.carousel.js",

        // lightbox
        "lightbox2/dist/js/lightbox.js",

        // summernote
        'summernote/dist/summernote.js',

        // validation
        "formvalidation/dist/js/formValidation.js",
        "formvalidation/dist/js/framework/bootstrap.js",

        // table
        "bootstrap-table/dist/bootstrap-table.min.js",

        // date time picker
        "eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js",

        // autocomplete
        "devbridge-autocomplete/dist/jquery.autocomplete.js",

        // echo
        "echojs/dist/echo.js",

        // zoom
        "elevatezoom/jquery.elevatezoom.js",

        // rating
        "bootstrap-rating/bootstrap-rating.js",

        // scroll up
        "scrollup/dist/jquery.scrollUp.min.js",

        // pace
        "pace/pace.js"

    ], "public/js/frontend/libs.js", bowerAssetsDir);


    // ADMIN SCRIPTS
    // mix some scripts required at the backend section

    mix.scripts([

        "ajax/script.js",

        "script.js"

    ], "public/js/backend/modules.js", "resources/assets/js/custom/libs/");

    mix.scripts([

        // data tables
        "datatables/media/js/jquery.dataTables.js",
        "datatables-bootstrap3/BS3/assets/js/datatables.js"

    ], "public/js/backend/libs.js", bowerAssetsDir);
});