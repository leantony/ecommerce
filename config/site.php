<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Application Backend configuration
    |--------------------------------------------------------------------------
    |
    | The backend is the part of the application that is accessible to admin personell.
    | Use this section to configure essential security options
    |
    */
    'backend' => [

        // Define a list of IP addresses that can access the backend
        'allowedIPS' => [
            '::1', '127.0.0.1',
        ],

        // Define roles applicable to users accessing the backend
        'allowedRoles' => [
            'Administrator',
            'Manager'
        ]

    ],

    /*
    |--------------------------------------------------------------------------
    | User Accounts
    |--------------------------------------------------------------------------
    |
    | Use this section to configure options related to user accounts, e.g signIn
    |
    */
    'account' => [

        'authentication' => [

            /*
             * OAUTH2 is a widely accepted and secure means of user authentication, that allows users to
             * sign in using various services.
             */
            'OAUTH2' => [

                // Specify the list of allowed OAUTH2 services
                'apis' => ['google', 'facebook'],

                // Enable user login, using OAUTH2
                'login' => true,

                // Enable user registration using OATH2
                'registration' => true,
            ],
        ],

        /*
         * Configure options related to user account activation
         */
        'activation' => [

            // Enable account activation via email
            'email' => false,

            // Enable users to login, without activating their accounts. Good for a development environment

            'allow_login' => false,

            /*
             * Automatically login a user once they activate their account via email. Let this be false
             * for security reasons
             */
            'autologin' => false,
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Location of static resources
    |--------------------------------------------------------------------------
    |
    | In this case, static resources are those that wont change, for both the
    | backend and frontend. Examples are images
    |
    */
    'static' => [

        // Image displayed when an image isnt found on the filesystem
        'error' => '/assets/images/Error/imageNotFound.jpg',

        // default user avatar
        'avatar' => '/assets/images/default-avatar.jpg',

        // blank image
        'blank' => '/assets/images/blank.gif',

        /*
         * AJAx loaders
         */
        'ajax' => '/assets/images/ajax-loader.gif',

        'ajax2' => '/assets/images/alt-ajax-loader.gif',

        'ajax3' => '/assets/images/ajax-loader-large.gif',
    ],

    /*
    |--------------------------------------------------------------------------
    | View composers
    |--------------------------------------------------------------------------
    |
    | View composers are an essential laravel feature, which allow us to reuse
    | page content. Define/change some options here
    |
    */
    'composers' => [
        // how long should we cache? (minutes)
        'cache_duration' => 30
    ],


    /*
    |--------------------------------------------------------------------------
    | Money $$$$
    |--------------------------------------------------------------------------
    |
    | Configure various options related to money. E.g VAT, default currency, etc
    |
    */
    'money' => [

        // Set the default currency
        'default_currency' => 'KES',

        // Set the VAT rate
        'VAT_RATE' => 0.16,

    ],

    /*
    |--------------------------------------------------------------------------
    | Products
    |--------------------------------------------------------------------------
    |
    | Configuration options related to the products model
    |
    */
    'products' => [
        /*
         * Duration in days for which  a product is defined as new. This option would influence the no
         * of products displayed on the homepage, under the section 'new products'
         */
        'new' => [
            'age' => 14
        ],

        /*
         * Configuration related to product images
         */
        'images' => [

            /*
             * When a product image is uploaded, it is diminished by a factor X, so that the smaller
             * image can be used during providing the client with zoom capability. Factor X is specified here
             */
            'reduce_ratio' => 3,

            /*
             * If the actual un-diminished image should be resized,
             * specify the dimensions for doing so here
             */
            'dimensions' => [
                'new_width' => 1920,
                'new_height' => 1080
            ],

            /*
             * Specify the location where the images should be saved
             */
            'storage' => "/public/assets/images/products",
        ],

        /*
         * Product options related to Quantities
         */
        'quantity' => [

            /*
             * Specifies if the quantity of an existing product should be displayed to the end user
             */
            'display' => false,

            // the max quantity that can be displayed in a quantity dropdown
            // if exceeded, we will display a text box for the user
            'max_selectable' => 10,

            // the quantity of a product that will trigger a warning message
            'low_threshold' => 2,

        ],

        /*
         * Product reviews
         */
        'reviews' => [

            // Specify the number of reviews to display on the product details page
            'display' => 5
        ]
    ],

    /*
    |--------------------------------------------------------------------------
    | Product Brands
    |--------------------------------------------------------------------------
    |
    | Configuration options related to the product brands model
    |
    */
    'brands' => [

        'images' => [

            /*
             * If the image should be resized,
             * specify the dimensions for doing so here
             */
            'dimensions' => [
                'new_width' => 220,
                'new_height' => 110
            ],

            /*
             * Specify the location where the images should be saved
             */
            'storage' => "/public/assets/images/brands",
        ],

    ],


    /*
    |--------------------------------------------------------------------------
    | Users
    |--------------------------------------------------------------------------
    |
    | Configuration options related to the users model
    |
    */
    'users' => [

        'images' => [

            /*
             * Specify the location where the user avatars should be saved
             * If a user's avatar is handled by an external service, it wont be saved here
             */
            'storage' => '/public/assets/images/users/profilePics',
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Product reviews
    |--------------------------------------------------------------------------
    |
    | Configuration options related to the reviews model
    |
    */
    'reviews' => [

        /*
         * Change the number of stars to display. Options are 5, or 10
         */
        'stars' => 5,

        /*
         * Sometimes products are displayed according to their rating. Products with
         * an average star rating greater than the one defined below would be displayed
         */
        'hottest' => 4.0,

        /*
         * During displaying top rated products, we not only need to know the average rating
         * but also how many times it was given a top rating. That top rating has been defined above
         */
        'count' => 5
    ],

    /*
    |--------------------------------------------------------------------------
    | Checkout
    |--------------------------------------------------------------------------
    |
    | Configure options related to user checkout
    |
    */
    'checkout' => [

        // allow users to checkout as guests
        'allow_guest_checkout' => true,
    ],

    // client help
    'help' => [

        // enable or disable olark chart. Olark is a chat plugin
        'olark_chart' => [
            'backend' => false,
            'frontend' => false,
        ]
    ]
];