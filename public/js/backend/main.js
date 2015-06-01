(function ($) {

    $(document).ready(function () {
        new WOW().init();
    });
    // auto close the flash notification
    setTimeout(function () {
        $('.flash-msg').fadeOut()
    }, 15000);

    // hide the ajax image
    $('.loading-image').hide();

    $('.custom-editor').summernote({height: 300});

    $("[data-toggle='tooltip']").tooltip();
    $('[data-toggle="popover"]').popover();
    $('#flash-overlay-modal').modal();

    // select boxes
    $(".users-roles").select2({
        placeholder: "select a user"
    });

    $(".product-categories").select2({
        placeholder: "select a category"
    });

    $(".product-subcategories").select2({
        placeholder: "select a sub-category"
    });

    $(".product-brands").select2({
        placeholder: "select a manufacturer"
    });

    $(".roles-assignment").select2({
        placeholder: "select roles"
    });

    $(".permissions-assignment").select2({
        placeholder: "select permissions for this role"
    });

    $(".advert-products").select2({
        placeholder: "select a product"
    });

    $(".ads-mode").select2({
        placeholder: "how will the ad be represented?"
    });

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
