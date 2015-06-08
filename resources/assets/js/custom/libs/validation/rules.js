/**
 * Validation form rules
 */
var _validator = _validator || {};

_validator.formsRules = {

    // login
    login: {
        email: _validator.fields.email,
        password: _validator.fields.loginPassword
    },

    // user registration
    registration: {
        first_name: _validator.fields.first_name,
        last_name: _validator.fields.last_name,
        phone: _validator.fields.phone,
        town: _validator.fields.town,
        email: _validator.fields.email,
        home_address: _validator.fields.home_address,
        password: _validator.fields.password,
        password_confirmation: _validator.fields.password_confirmation,
        accept: _validator.fields.accept
    },

    // requesting to reset a password
    forgot: {
        email: _validator.fields.email
    },

    // resetting a password
    resetPassword: {
        email: _validator.fields.email,
        password: _validator.fields.password,
        password_confirmation: _validator.fields.password_confirmation

    },

    // commenting on a product
    reviews: {
        comment: _validator.fields.comment,
        stars: _validator.fields.stars
    },

    // checking out as a guest
    guestCheckout: {
        first_name: _validator.fields.first_name,
        last_name: _validator.fields.last_name,
        town: _validator.fields.town,
        home_address: _validator.fields.home_address,
        phone: _validator.fields.phone,
        email: _validator.fields.email

    },

    // creating an account as a guest user
    guestCheckoutMakeAccount: {
        password: _validator.fields.password,
        password_confirmation: _validator.fields.password_confirmation,
        accept: _validator.fields.accept
    },

    // editing the password, in the user profile section
    accountPasswordEdit: {
        password: _validator.fields.password,
        password_confirmation: _validator.fields.password_confirmation
    },

    // editing user contact information in their profile section
    contactInfoEdit: {
        phone: _validator.fields.phone,
        email: _validator.fields.email
    }

};