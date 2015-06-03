/**
 * AJAX handler
 */

var pcWorld = pcWorld || {};

var ajaxImage = $("#ajax-image");
var altAjaxImage = $('.alt-ajax-image');

pcWorld.ajax = {

    ajaxImage: ajaxImage,

    altAjaxImage: altAjaxImage,

    ajaxLoader: this.altAjaxImage.length === 0 ? this.ajaxImage : this.altAjaxImage,

    setup: {

        init: function () {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                beforeSend: function () {
                    // show image here
                    pcWorld.ajax.ajaxLoader.show();
                },
                complete: function () {
                    // hide image here
                    pcWorld.ajax.ajaxLoader.hide();
                }
            })
        }
    },

    errors: {
        displayErrors: function displayErrorsOnDiv(div, errors, single) {
            // build a small bootstrap alert box that will be placed inside the target element
            var target = '<div class="alert alert-danger force-list-style animated shake">' +
                '<p class=\"bold\">Please fix the errors below</p>' +
                '<ul>';

            if (single === false) {
                // display all errors in this alert box
                $.each(errors, function (key, value) {
                    target += '<li>' + value[0] + '</li>';
                });
            } else {
                target += '<li>' + errors + '</li>';
            }

            target += '</ul></div>';

            // append the errors as html to the created element
            div.html(target);
        },

        executeDefaultHandler: function (data, infoDisplay) {
            var errors;

            if (data.status === 422) {
                errors = data.responseJSON;
                //console.log(errors);
                pcWorld.ajax.errors.displayErrors(infoDisplay, errors, false);
            } else {

                errors = data.responseJSON.message;
                //console.log(errors);
                pcWorld.ajax.errors.displayErrors(infoDisplay, errors, true);
            }
        }
    },

    handleSuccess: {
        displaySuccessMsg: function (response) {

            swal({
                allowOutsideClick: false,
                title: "Success!",
                text: response.message,
                type: "success",
                confirmButtonColor: "#3498db"
            }, function () {
                pcWorld.ajax.handleSuccess.doRedirect(response);
            });
        },

        doRedirect: function (response) {
            console.log(response.target);
            if (response.target === null || typeof response.target === 'undefined') {
                window.location.reload();
            } else {
                window.location.href = response.target
            }

        }
    }

};