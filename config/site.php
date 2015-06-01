<?php
// site config file
return [

    // backend config
    'backend' => [
        // ip addresses that can access the backend.
        'allowedIPS' => [
            '::1',
            '127.0.0.1',
            '192.168.4.118',
            '192.168.4.1',
            '192.168.4.9',
            '192.168.4.48'
        ],
        // only users with this roles will access the backend
        'allowedRoles' => [
            'Administrator',
            'Manager'
        ]

    ],

    // user account configs
    'account' => [
        'authentication' => [

            'OAUTH2' => [
                // allowed OAUTH API's
                'apis' => ['google', 'facebook'],
                // enable login, from fb, twitter, google, etc
                'login' => true,
                // enable registration from fb, twitter, google, etc
                'registration' => true,
            ],
        ],

        // activation of user accounts, and login options afterwards
        'activation' => [
            // enforce account activation via email
            'enabled' => false,
            // allow users to login, without activating their accounts
            'allow_login' => false,
            // auto login the user, once they confirm/activate their account via email
            'autologin' => false,
        ],

    ],

    // config for default images
    'static' => [
        // error image location
        'error' => '/assets/images/Error/imageNotFound.jpg',
        // default user avatar
        'avatar' => '/assets/images/default-avatar.jpg',
        // blank image
        'blank' => '/assets/images/blank.gif',
        // the ajax loaders
        'ajax' => '/assets/images/ajax-loader.gif',

        'ajax2' => '/assets/images/alt-ajax-loader.gif',

        'ajax3' => '/assets/images/ajax-loader-large.gif',
    ],

    // view composers
    'composers' => [
        // how long should we cache? (minutes)
        'cache_duration' => 30
    ],

    /* config for models */

    // ads
    'ads' => [

        'storage' => '/public/assets/images/ads'
    ],

    // money
    'currencies' => [

        'default' => 'KES'
    ],
    // products
    'products' => [
        // The age of a new product (days)
        'new' => [
            'age' => 14
        ],
        // VAT % value/100
        'VAT' => 0.16,
        // product images
        'images' => [
            // image resize ratio -> big:small. This is evident since a product will have two images,
            // one small and the other large
            'reduce_ratio' => 3,
            // resize dimensions
            'dimensions' => [
                'width' => 1920,
                'height' => 1080
            ],
            // image storage area
            'storage' => "/public/assets/images/products",
        ],
        // product quantity
        'quantity' => [
            // option to display quantity of a product to end user
            'display' => false,

            // the max quantity that can be displayed in a quantity dropdown
            // if exceeded, we will display a text box for the user
            'max_selectable' => 10,

            // the quantity of a product that will trigger a warning message
            'low_threshold' => 2,

        ],
        // product reviews to be displayed on the product details page
        'reviews' => [
            'display' => 5
        ]
    ],

    // product brands
    'brands' => [

        'images' => [
            // resize dimensions
            'dimensions' => [
                'width' => 220,
                'height' => 110
            ],
            // storage area
            'storage' => "/public/assets/images/brands",
        ],

    ],

    // system users
    'users' => [

        'images' => [
            // storage
            'storage' => '/public/assets/images/users/profilePics',
        ],

    ],

    // product reviews
    'reviews' => [
        // how many stars should we display for a rating?. Applies to both input and output
        'stars' => 5,
        // how many stars should a 'hot' product have
        'hottest' => 4.0,
        // the total count of the hot stars. This count represents unique users who reviewed the product
        'count' => 5
    ],

    // checkout
    'checkout' => [
        'allow_guest_checkout' => true,
    ],

    // client help
    'help' => [

        // enable or disable olark chart
        'olark_chart' => [
            'backend' => false,
            'frontend' => false,
        ]
    ]
];