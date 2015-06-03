(function () {

    // AJAX
    $('form[data-remote]').on('submit', function (e) {

        var form = $(this);
        var method = form.find('input[name="_method"]').val() || 'POST';
        var data = form.serialize();
        var url = form.prop('action');
        var infoDisplay = $('.msgDisplay');

        //console.log(data);

        // init ajax request...send the csrf token and display the loading images
        pcWorld.ajax.setup.init();

        $.ajax({
            type: method,
            url: url,
            data: data,
            success: function (response) {

                console.log(response);

                if (typeof response.message === 'undefined') {
                    pcWorld.ajax.handleSuccess.doRedirect(response);
                } else {
                    pcWorld.ajax.handleSuccess.displaySuccessMsg(response);
                }
            },

            error: function (data) {
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

                //console.log(form.parent('div').height());
                if (form.parent('div').height() > 768) {
                    // scroll to the errors div
                    $('html, body').animate({
                        scrollTop: infoDisplay.offset().top
                    }, 2000);
                }
            }
        });

        e.preventDefault();
    });

    // alert before action
    $("button[data-confirm], a[data-confirm]").on('click', function (e) {

        var element = $(this);
        var form = element.closest('form');
        console.log(form.length);
        e.preventDefault();

        swal({
            allowOutsideClick: false,
            title: "Confirm your action",
            text: element.data('confirm'),
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3498db",
            confirmButtonText: "Yes",
            closeOnConfirm: false
        }, function (confirm) {
            if (confirm) {
                if (form.length > 0) {
                    form.unbind('submit').submit();
                } else {
                    // not good. assumes presence of a link
                    window.location = element.attr('href');
                }
            }
        });
    });

    // confirm password
    $("button[data-confirm-password]").on('click', function (e) {

        var lnk = $(this);
        var link = lnk.closest('form').prop('action');
        console.log(link);
        e.preventDefault();

        swal({
                title: "Password confirmation",
                text: "Before you continue, please confirm your password",
                type: "input",
                inputValue: "password",
                inputType: "password",
                confirmButtonColor: "#3498db",
                showCancelButton: true,
                closeOnConfirm: false,
                animation: "slide-from-top"
            },
            function (inputValue) {
                if (inputValue === false)
                    return false;
                if (inputValue === "") {
                    swal.showInputError("You need to enter your password");
                    return false;
                }
                // check the password
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.post(link, function (data, status) {

                    if (status === 401) {
                        swal("Invalid password", "The password you provided is incorrect", "error");
                    }
                });
                //window.location.href = link;
            });
    });

    // dynamic help popup
    $("a[data-help]").on('click', function (e) {

        var element = $(this);
        var link = element.attr('href');
        // popup height and width
        var height = element.data('height') || 570;
        var width = element.data('width') || 520;
        window.open(link, '_blank', 'location=yes,height=' + height + ',width=' + width + ',scrollbars=yes,status=yes');

        // we cancel the event stop the link from opening
        e.preventDefault();
    });

    // close a popup
    $("a[data-close-popup]").on('click', function (e) {

        window.close();
    });

    // scroll up
    $(function () {
        $.scrollUp({
            scrollName: 'scrollUp',
            scrollDistance: 300,
            scrollFrom: 'top',
            scrollSpeed: 300,
            easingType: 'linear',
            animation: 'fade',
            animationSpeed: 200,
            scrollTrigger: false,
            scrollTarget: false,
            scrollText: 'Scroll to top',
            scrollTitle: false,
            scrollImg: false,
            activeOverlay: false,
            zIndex: 2147483647
        });
    });

    // print document
    $("a[data-print-content]").on('click', function (e) {

        window.print();
    });

    // disable submission of a form totally. some form actions have not been implemented yet.
    // an example is the newsletter form
    $('form[data-disable-submission]').on('submit', function (e) {

        e.preventDefault();

    });

    // oauth2 popup
    $("a[data-oauth2-connect]").on('click', function (e) {

        e.preventDefault();
        var win;
        var checkConnect;
        var height = 550;
        var width = 550;
        var trigger = $(this);
        var title = trigger.data('title') || "External Service login";
        var oAuthURL = trigger.attr('href');

        win = window.open(oAuthURL, title, 'width=' + width + ',height=' + height + ',modal=yes,alwaysRaised=yes');

        do {
            console.log(window.process_done);
            checkConnect = setInterval(function () {
                if (!win || !win.closed) return;
                clearInterval(checkConnect);
                window.location.reload();
            }, 100);

        } while (typeof window.process_done !== 'undefined');

    });

    // animate objects in
    $("div[data-toggle-animation], section[data-toggle-animation]").addClass('wow fadeIn');

    //$('.row div, .section').addClass('wow fadeIn');

    // open tabs pragmatically
    $("a[data-open-tab]").on('click', function (e) {

        $(this).tab('show');
    });

})();