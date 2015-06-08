/**
 * The validator settings and ajax handler
 */

var _validator = _validator || {};

// settings
_validator.settings = {

    errorsDisplay: $('.msgDisplay'),

    framework: "bootstrap",
    icons: {
        valid: 'glyphicon glyphicon-ok',
        invalid: 'glyphicon glyphicon-remove',
        validating: 'glyphicon glyphicon-refresh'
    }

};

// validation, ajax handler
_validator.ajaxHandler = function (form, rules) {

    var infoDisplay = _validator.settings.errorsDisplay;

    // login form
    $(form)
        .formValidation({

            icon: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: rules
        })
        .on('success.form.fv', function (e) {
            // Prevent form submission
            e.preventDefault();

            var $form = $(e.target),
                fv = $form.data('formValidation');

            // Use Ajax to submit form data
            pcWorld.ajax.setup.init();

            $.ajax({
                url: $form.attr('action'),
                type: $form.find('input[name="_method"]').val() || 'POST',
                data: $form.serialize(),
                success: function (result) {

                    if (typeof result.message === 'undefined') {
                        pcWorld.ajax.handleSuccess.doRedirect(result);
                    } else {
                        pcWorld.ajax.handleSuccess.displaySuccessMsg(result);
                    }
                },

                error: function (data) {
                    pcWorld.ajax.errors.executeDefaultHandler(data, infoDisplay);
                }

            });
        });
};