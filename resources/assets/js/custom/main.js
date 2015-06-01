(function ($) {
    "use strict";

    $(document).ready(function () {
        new WOW().init();
    });

    // homepage slider
    $(document).ready(function () {

        $("#main-slider").owlCarousel({

            autoPlay: 5000,
            slideSpeed: 300,
            paginationSpeed: 400,
            singleItem: true
        });

    });

    // auto close the flash notification
    setTimeout(function () {
        $('.flash-msg').fadeOut()
    }, 5000);

    // lazy loading images
    $(document).ready(function () {
        echo.init({
            offset: 100,
            throttle: 250,
            unload: false
        });
    });

    // select 2 box
    $("#county-input").select2({
        placeholder: "select a county"
    });

    // initialize bootstrap carousel, tooltip, popover, modal
    $('.carousel').carousel();

    $("[data-toggle='tooltip']").tooltip();

    $('[data-toggle="popover"]').popover();
    $('#flash-overlay-modal').modal();

    // zooming over product images
    $("#zoom_img").elevateZoom({
        scrollZoom: true,
        zoomWindowFadeIn: 500,
        zoomWindowFadeOut: 500,
        lensFadeIn: 500,
        lensFadeOut: 500,
        cursor: "crosshair"
    });

    // img preview
    $(document).on('click', '#close-preview', function () {
        var img = $('.image-preview');
        img.popover('hide');
        // Hover before close the preview
        img.hover(
            function () {
                img.popover('show');
            },
            function () {
                img.popover('hide');
            }
        );
    });

    $(function () {
        // Create the close button
        var closebtn = $('<button/>', {
            type: "button",
            text: 'x',
            id: 'close-preview',
            style: 'font-size: initial;'
        });
        closebtn.attr("class", "close pull-right");
        // Set the popover default content
        $('.image-preview').popover({
            trigger: 'manual',
            html: true,
            title: "<strong>Preview</strong>" + $(closebtn)[0].outerHTML,
            content: "There's no image",
            placement: 'bottom'
        });
        // Clear event
        $('.image-preview-clear').click(function () {
            $('.image-preview').attr("data-content", "").popover('hide');
            $('.image-preview-filename').val("");
            $('.image-preview-clear').hide();
            $('.image-preview-input input:file').val("");
            $(".image-preview-input-title").text("Browse");
        });
        // Create the preview image
        $(".image-preview-input input:file").change(function () {
            var img = $('<img/>', {
                id: 'dynamic',
                width: 250,
                height: 200
            });
            var file = this.files[0];
            var reader = new FileReader();
            // Set preview image into the popover data-content
            reader.onload = function (e) {
                $(".image-preview-input-title").text("Change");
                $(".image-preview-clear").show();
                $(".image-preview-filename").val(file.name);
                img.attr('src', e.target.result);
                $(".image-preview").attr("data-content", $(img)[0].outerHTML).popover("show");
            };
            reader.readAsDataURL(file);
        });
    });

    // date time picker for account data
    $('.dateOfBirthDatetimePicker').datetimepicker(
        ({
            viewMode: 'years',
            format: 'YYYY-MM-DD'
        })
    );
})(jQuery);