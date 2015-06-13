/**
 * Forms to be validated using AJAX
 */
(function () {

    // login form
    //_validator.ajaxHandler('#loginForm', _validator.formsRules.login);

    // registration form
    _validator.ajaxHandler('#registrationForm', _validator.formsRules.registration);

    // check out form for a guest
    _validator.ajaxHandler('#guestCheckoutForm', _validator.formsRules.guestCheckout);

    // reviews form
    //_validator.ajaxHandler('#reviewsForm', _validator.formsRules.reviews);

    // editing contact info
    //_validator.ajaxHandler('#editContactInfo', _validator.formsRules.contactInfoEdit);


    // editing account password
    //_validator.ajaxHandler('#simplePasswordResetForm', _validator.formsRules.accountPasswordEdit);

    // forgot password
    //_validator.ajaxHandler('#forgotPassword', _validator.formsRules.forgot);


})();