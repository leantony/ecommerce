/**
 * common validation fields
 */
var _validator = _validator || {};

_validator.fields = {
    email: {
        validators: {
            notEmpty: {
                message: 'Please enter your email address'
            },
            emailAddress: {
                message: 'Please enter a valid email address'
            }
        }
    },
    password: {
        validators: {
            notEmpty: {
                message: 'Please enter your password'
            },
            stringLength: {
                min: 6,
                max: 30,
                message: 'Your password must be between 6 and 30 characters'
            }
        }
    },
    loginPassword: {
        validators: {
            notEmpty: {
                message: 'Please enter your password'
            }
        }
    },
    password_confirmation: {
        validMessage: 'Good. The passwords match',
        validators: {
            notEmpty: {
                message: 'Please repeat your password'
            },
            identical: {
                field: 'password',
                message: 'The passwords do not match'
            }
        }
    },
    comment: {
        notEmpty: {
            message: 'Please enter your comment'
        },
        stringLength: {
            min: 3,
            max: 500,
            message: 'your comment must be between 3 and 500 characters'
        }
    },
    stars: {
        notEmpty: {
            message: 'Please pick a star rating'
        }
    },
    first_name: {
        validators: {
            notEmpty: {
                message: 'Please enter your first name'
            },
            stringLength: {
                min: 3,
                max: 20,
                message: 'The name must be between 3 and 20 characters'
            },
            regexp: {
                regexp: /^[a-z\s]+$/i,
                message: 'The name can consist of alphabetical characters and spaces only'
            }
        }
    },
    last_name: {
        validators: {
            notEmpty: {
                message: 'Please enter your last/second name'
            },
            stringLength: {
                min: 3,
                max: 20,
                message: 'The name must be between 3 and 20 characters'
            },
            regexp: {
                regexp: /^[a-z\s]+$/i,
                message: 'The second name can consist of alphabetical characters and spaces only'
            }
        }
    },
    phone: {
        validators: {
            notEmpty: {
                message: 'Please enter your phone number e.g 7123456789'
            },
            stringLength: {
                min: 9,
                max: 9,
                message: 'Your phone number should consist of 9 digits'
            },
            numeric: {
                lessThan: 9,
                message: 'That is not a valid number'
            }
        }
    },
    town: {
        validators: {
            notEmpty: {
                message: 'Please enter your hometown'
            },
            stringLength: {
                min: 3,
                max: 30,
                message: 'The town name must be between 3 and 30 characters'
            },
            regexp: {
                regexp: /^[a-z\s]+$/i,
                message: 'The town name can consist of alphabetical characters and spaces only'
            }
        }
    },
    home_address: {
        validators: {
            notEmpty: {
                message: 'Please enter your home address'
            },
            stringLength: {
                min: 3,
                max: 100,
                message: 'The home address must be between 3 and 100 characters'
            }
        }
    },
    accept: {
        validators: {
            choice: {
                min: 1,
                message: 'Please accept the terms of agreement'
            }
        }
    }
};