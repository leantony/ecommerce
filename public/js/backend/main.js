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

    $('#counties-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '/backend/api/counties/data',
        columns: [
            {data: 'id', name: 'id'},
            {data: 'name', name: 'name'},
            {data: 'alias', name: 'alias'},
            {data: 'created_at', name: 'created_at'},
            {data: 'updated_at', name: 'updated_at'},
            {data: 'edit', name: 'edit', orderable: false, searchable: false}
        ]
    });

    $('#articles-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '/backend/api/articles/data',
        columns: [
            {data: 'id', name: 'id'},
            {data: 'topic', name: 'topic'},
            {data: 'created_at', name: 'created_at'},
            {data: 'updated_at', name: 'updated_at'},
            {data: 'edit', name: 'edit', orderable: false, searchable: false}
        ]
    });

    $('#categories-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '/backend/api/categories/data',
        columns: [
            {data: 'id', name: 'id'},
            {data: 'name', name: 'name'},
            {data: 'created_at', name: 'created_at'},
            {data: 'updated_at', name: 'updated_at'},
            {data: 'edit', name: 'edit', orderable: false, searchable: false}
        ]
    });

    $('#brands-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '/backend/api/brands/data',
        columns: [
            {data: 'id', name: 'id'},
            {data: 'name', name: 'name'},
            {data: 'count', name: 'count', orderable: false, searchable: false},
            {data: 'created_at', name: 'created_at'},
            {data: 'updated_at', name: 'updated_at'},
            {data: 'edit', name: 'edit', orderable: false, searchable: false}
        ]
    });

    $('#subcategories-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '/backend/api/subcategories/data',
        columns: [
            {data: 'id', name: 'id'},
            {data: 'name', name: 'name'},
            {data: 'category.name', name: 'name', orderable: false, searchable: false},
            {data: 'created_at', name: 'created_at'},
            {data: 'updated_at', name: 'updated_at'},
            {data: 'edit', name: 'edit', orderable: false, searchable: false}
        ]
    });

    $('#users-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '/backend/api/users/data',
        columns: [
            {data: 'id', name: 'id'},
            {data: 'first_name', name: 'first_name'},
            {data: 'last_name', name: 'last_name'},
            {data: 'email', name: 'email'},
            {data: 'county.name', name: 'name', orderable: false, searchable: false},
            {data: 'created_at', name: 'created_at'},
            {data: 'updated_at', name: 'updated_at'},
            {data: 'edit', name: 'edit', orderable: false, searchable: false}
        ]
    });

    $('#products-table').DataTable({
        "dom": 'T<"clear">lfrtip',
        "tableTools": {
            "sSwfPath": "/swf/copy_csv_xls_pdf.swf"
        },
        processing: true,
        serverSide: true,
        ajax: '/backend/api/products/data',
        columns: [
            {data: 'id', name: 'id'},
            {data: 'name', name: 'name'},
            {data: 'category.name', name: 'category', orderable: false, searchable: false},
            {data: 'subcategory.name', name: 'subcategory', orderable: false, searchable: false},
            {data: 'brand.name', name: 'brand', orderable: false, searchable: false},
            {data: 'quantity', name: 'quantity'},
            {data: 'price', name: 'price'},
            {data: 'created_at', name: 'created_at'},
            {data: 'updated_at', name: 'updated_at'},
            {data: 'edit', name: 'edit', orderable: false, searchable: false}
        ]
    });

    $('#order-users-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '/backend/api/orders/data/users',
        columns: [
            {data: 'id', name: 'id'},
            {data: 'user', name: 'user', orderable: false, searchable: false},
            {data: 'email', name: 'email', orderable: false, searchable: false},
            {data: 'quantity', name: 'quantity'},
            {data: 'price', name: 'price'},
            {data: 'created_at', name: 'created_at'},
            {data: 'delivered', name: 'delivered'},
            {data: 'details', name: 'details', orderable: false, searchable: false}
        ]
    });

    $('#order-guests-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '/backend/api/orders/data/guests',
        columns: [
            {data: 'id', name: 'id'},
            {data: 'user', name: 'user', orderable: false, searchable: false},
            {data: 'email', name: 'email', orderable: false, searchable: false},
            {data: 'quantity', name: 'quantity'},
            {data: 'price', name: 'price'},
            {data: 'created_at', name: 'created_at'},
            {data: 'delivered', name: 'delivered'},
            {data: 'details', name: 'details', orderable: false, searchable: false}
        ]
    });

    // $("[data-table-enable-utilities='1']").dataTable( {
    //     "dom": 'T<"clear">lfrtip',
    //     "tableTools": {
    //         "sSwfPath": "/swf/copy_csv_xls_pdf.swf"
    //     }
    // });

})(jQuery);
