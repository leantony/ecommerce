/**
 * Forms to be validated using AJAX
 */
(function () {

    // login form
    // _validator.ajaxHandler('#loginForm', _validator.formsRules.login);
    //_validator.ajaxHandler('#guestCreateAccount', _validator.formsRules.guestCheckoutMakeAccount);

    // registration form
    // _validator.ajaxHandler('#registrationForm', _validator.formsRules.registration);

    // check out form for a guest
    _validator.ajaxHandler('#guestCheckoutForm', _validator.formsRules.guestCheckout);
})();