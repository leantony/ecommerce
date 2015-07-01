<?php

Route::group(['prefix' => ''], function () {

    // home page
    get('/', ['as' => 'home', 'uses' => 'Frontend\HomeController@index', 'middleware' => ['http']]);

    Route::group(['prefix' => 'help'], function () {

        get('/', ['as' => 'help', 'uses' => 'Shared\HelpController@index']);
        // help & faq
        get('/faq', ['as' => 'faq', 'uses' => 'Shared\HelpController@displayFAQ']);
        get('/article/{articles}', ['as' => 'help.article.view', 'uses' => 'Shared\HelpController@show']);
    });

    // info pages
    Route::group(['prefix' => 'info', 'middleware' => ['http']], function () {

        // requesting the about page
        get('about', ['as' => 'about', 'uses' => 'Frontend\Contacts\InfoController@getAbout']);

        // requesting the terms & conditions page
        get('termsofuse', ['as' => 'terms', 'uses' => 'Frontend\Contacts\InfoController@getTerms']);

        // requesting the contact page
        get('contact', ['as' => 'contact', 'uses' => 'Frontend\Contacts\InfoController@getContact']);

        // this will handle the action of a user sending a message to us. since the form is already by default on the page, we don't need a GET request
        post('contact', ['as' => 'contact.post', 'uses' => 'Frontend\Contacts\InfoController@postContactMessage', 'middleware' => ['msg.check']]);
    });

    // authentication
    Route::group(['prefix' => 'account', 'middleware' => ['https']], function () {

        // login
        Route::group(['prefix' => 'login'], function () {

            // requesting the login page
            get('/', ['as' => 'login', 'uses' => 'Shared\AuthController@getLogin']);

            // posting to the login page, for credentials validation
            post('/', ['as' => 'login.verify', 'uses' => 'Shared\AuthController@postLogin']);

        });

        // OAUTH
        Route::group(['prefix' => 'auth/oauth2'], function () {

            // API login
            get('/', ['as' => 'auth.loginUsingAPI', 'uses' => 'Shared\AuthController@apiAuth', 'middleware' => 'api.authenticate']);

            // account creation. Requires that a valid user was returned by the API
            get('/register', ['as' => 'auth.fill', 'uses' => 'Shared\AuthController@getMiniRegistrationForm', 'middleware' => 'user.found']);
            post('/register', ['as' => 'auth.fill.post', 'uses' => 'Shared\AuthController@createAccountViaOAUTHData', 'middleware' => 'user.found']);

            // handle user verification via OAUTH
            get('/callback', ['as' => 'auth.getDataFromAPI', 'uses' => 'Shared\AuthController@handleOAUTHCallback']);

        });

        // registration
        Route::group(['prefix' => 'register'], function () {
            // display registration form
            get('/', ['as' => 'register', 'uses' => 'Shared\AuthController@getRegister']);

            // process user registration
            post('/', ['as' => 'registration.store', 'uses' => 'Shared\AuthController@postRegister']);
        });

        // logout
        get('logout', ['as' => 'logout', 'uses' => 'Shared\AuthController@getLogout']);

        // account activation
        get('/activate/{code}', ['as' => 'account.activate', 'uses' => 'Shared\AuthController@getActivate']);

        // confirming a user's password
        post('/confirm_password', ['as' => 'confirm_password', 'uses' => 'Shared\AccountController@confirmPassword', 'middleware' => ['auth']]);

        // password reset
        Route::group(['prefix' => 'password'], function () {

            // display email form for password reset. This isn't used entirely because displaying the form is done via a modal
            get('/reset', ['as' => 'password.reset', 'uses' => 'Shared\PasswordController@getEmail']);

            // verifying email
            post('/reset', ['as' => 'reset.postEmail', 'uses' => 'Shared\PasswordController@postEmail']);

            // display the form for resetting a password
            get('/new/{token}', ['as' => 'reset.start', 'uses' => 'Shared\PasswordController@getReset']);

            // save the new password
            post('/new', ['as' => 'reset.finish', 'uses' => 'Shared\PasswordController@postReset']);
        });


    });

    // usr account
    Route::group(['prefix' => "myaccount", 'middleware' => ['auth', 'https']], function () {

        // account customizations
        get('/', ['as' => 'myaccount', 'uses' => 'Shared\AccountController@index']);

        patch('/Info/contact', ['as' => 'account.info.contact.edit', 'uses' => 'Shared\AccountController@patchContacts']);

        patch('/Info/add', ['as' => 'account.info.addMore', 'uses' => 'Shared\AccountController@patchAccountAddingMoreDetails', 'middleware' => ['age.filter']]);

        patch('/Info/personal', ['as' => 'account.info.personal.edit', 'uses' => 'Shared\AccountController@patchAccount', 'middleware' => ['age.filter']]);

        patch('/Info/shipping', ['as' => 'account.info.shipping.edit', 'uses' => 'Shared\AccountController@patchShipping']);

        patch('/password/new', ['as' => 'account.password.edit', 'uses' => 'Shared\AccountController@patchPassword']);

        delete('/delete', ['as' => 'account.delete.temporary', 'uses' => 'Shared\AccountController@deleteAccount']);

    });

    // categories
    Route::group(['prefix' => 'categories', 'middleware' => ['http']], function () {
        // listing categories. sort of sitemaping, or whatever
        get('/', ['as' => 'allCategories', 'uses' => 'Frontend\Inventory\CategoriesController@index']);

        // display all products in the category, regardless of sub-category
        get('/{categories}', ['as' => 'categories.shop', 'uses' => 'Frontend\Inventory\CategoriesController@show']);
    });

    // subcategories
    Route::group(['prefix' => 'sub-categories', 'middleware' => ['http']], function () {

        get('/', ['as' => 'allSubCategories', 'uses' => 'Frontend\Inventory\SubCategoriesController@index']);

        get('/{subcategories}', ['as' => 'subcategories.shop', 'uses' => 'Frontend\Inventory\SubCategoriesController@show']);
    });

    // products
    Route::group(['prefix' => 'products', 'middleware' => ['http']], function () {

        get('/', ['as' => 'allProducts', 'uses' => 'Frontend\Inventory\ProductsController@index']);

        get('/{products}', ['as' => 'product.view', 'uses' => 'Frontend\Inventory\ProductsController@show']);

    });

    // brands
    Route::group(['prefix' => 'brands', 'middleware' => ['http']], function () {

        get('/', ['as' => 'allBrands', 'uses' => 'Frontend\Inventory\BrandsController@index']);

        get('/{brands}', ['as' => 'brands.shop', 'uses' => 'Frontend\Inventory\BrandsController@show']);
    });

    // search
    Route::group(['prefix' => 'search'], function () {
        // handles a search request from the client
        get('/', ['as' => 'client.search', 'uses' => 'Frontend\Search\SearchController@show']);
    });

    // basket
    Route::group(['prefix' => 'basket'], function () {

        get('/', ['as' => 'cart.index', 'uses' => 'Frontend\Basket\CartController@index']);
        // adding a product to the cart
        post('add/product/{products}', ['as' => 'cart.add', 'uses' => 'Frontend\Basket\CartController@store']);
        // listing all products in the cart
        get('/', ['as' => 'cart.view', 'uses' => 'Frontend\Basket\CartController@view']);
        // add a product to an existing cart
        patch('/update/add/{products}', ['as' => 'cart.update', 'uses' => 'Frontend\Basket\CartController@update']);

        delete('/update/remove/{products}/remove', ['as' => 'cart.update.remove', 'uses' => 'Frontend\Basket\CartController@removeProduct']);

        delete('/update/removeAll', ['as' => 'cart.removeAllProducts', 'uses' => 'Frontend\Basket\CartController@removeAllProducts']);

        // a users shopping cart
        Route::group(['prefix' => '', 'middleware' => ['https', 'auth']], function () {

            get('/', ['as' => 'mycart', 'uses' => 'Frontend\Basket\CartController@getMine']);
        });
    });

    // reviews
    Route::group(['prefix' => 'reviews', 'middleware' => ['auth']], function () {

        post('/save/product/{productID}', ['as' => 'product.reviews.store', 'uses' => 'Frontend\Reviews\ReviewsController@store', 'middleware' => 'reviews.check']);

        patch('/edit/{id}', ['as' => 'product.reviews.update', 'uses' => 'Frontend\Reviews\ReviewsController@update']);
    });

    get('checkout/begin', ['as' => 'checkout.auth', 'uses' => 'Frontend\Checkout\GuestCheckoutController@auth', 'middleware' => ['https', 'cart.check']]);

    // checking out as a guest user
    Route::group(['prefix' => 'checkout/guest', 'middleware' => ['https', 'cart.check', 'checkout.guest']], function () {

        get('/', ['as' => 'checkout.step1', 'uses' => 'Frontend\Checkout\GuestCheckoutController@guestInfo']);

        post('/aboutMe', ['as' => 'checkout.step1.store', 'uses' => 'Frontend\Checkout\GuestCheckoutController@postGuestInfo']);

        patch('/aboutMe', ['as' => 'checkout.step1.edit', 'uses' => 'Frontend\Checkout\GuestCheckoutController@editShippingAddress']);

        get('/shipping', ['as' => 'checkout.step2', 'uses' => 'Frontend\Checkout\GuestCheckoutController@shipping']);

        patch('/shipping', ['as' => 'checkout.step2', 'uses' => 'Frontend\Checkout\GuestCheckoutController@patchShipping']);

        get('/payment', ['as' => 'checkout.step3', 'uses' => 'Frontend\Checkout\GuestCheckoutController@payment']);

        post('/payment', ['as' => 'checkout.step3.post', 'uses' => 'Frontend\Checkout\GuestCheckoutController@storePayment']);

        get('/reviewOrder', ['as' => 'checkout.step4', 'uses' => 'Frontend\Checkout\GuestCheckoutController@reviewOrder']);

        post('/placeOrder', ['as' => 'checkout.submitOrder', 'uses' => 'Frontend\Orders\OrdersController@store']);

        get('/viewInvoice', ['as' => 'checkout.viewInvoice', 'uses' => 'Frontend\Orders\OrdersController@displayInvoice', 'middleware' => ['orders.verify']]);

        get('/createAccount', ['as' => 'checkout.createAccount', 'uses' => 'Frontend\Checkout\GuestCheckoutController@getCreateAccount']);

        post('/createAccount', ['as' => 'checkout.createAccount.post', 'uses' => 'Frontend\Checkout\GuestCheckoutController@createAccount']);

        get('/invoice/pdf', ['as' => 'checkout.viewInvoice.pdf', 'uses' => 'Frontend\Orders\OrdersController@printInvoice', 'middleware' => ['orders.verify']]);

        get('/complete', ['as' => 'order.finished', 'uses' => 'Frontend\Orders\OrdersController@completeOrder', 'middleware' => ['orders.verify']]);
    });

    // checking out as a normal authenticated user
    Route::group(['prefix' => 'checkout', 'middleware' => ['https', 'cart.check', 'checkout.user']], function () {

        get('/', ['as' => 'u.checkout.step2', 'uses' => 'Frontend\Checkout\AuthUserCheckoutController@index']);

        patch('/shipping', ['as' => 'u.checkout.step2.patch', 'uses' => 'Frontend\Checkout\AuthUserCheckoutController@shipping']);

        get('/payment', ['as' => 'u.checkout.step3', 'uses' => 'Frontend\Checkout\AuthUserCheckoutController@payment']);

        post('/payment', ['as' => 'u.checkout.step3.post', 'uses' => 'Frontend\Checkout\AuthUserCheckoutController@storePayment']);

        get('/reviewOrder', ['as' => 'u.checkout.step4', 'uses' => 'Frontend\Checkout\AuthUserCheckoutController@reviewOrder']);

        get('/viewInvoice', ['as' => 'u.checkout.viewInvoice', 'uses' => 'Frontend\Orders\OrdersController@displayInvoice', 'middleware' => ['orders.verify']]);

        get('/invoice/pdf', ['as' => 'u.checkout.viewInvoice.pdf', 'uses' => 'Frontend\Orders\OrdersController@printInvoice', 'middleware' => ['orders.verify']]);

        post('/placeOrder', ['as' => 'u.checkout.submitOrder', 'uses' => 'Frontend\Orders\OrdersController@store']);

        get('/complete', ['as' => 'u.order.finished', 'uses' => 'Frontend\Orders\OrdersController@completeOrder', 'middleware' => ['orders.verify']]);

    });

    // users orders
    Route::group(['prefix' => 'myorders', 'middleware' => ['https', 'auth', 'orders.verify']], function () {

        get('/', ['as' => 'myorders', 'uses' => 'Frontend\Orders\OrdersController@index']);

        get('/{orders}', ['as' => 'viewOrder', 'uses' => 'Frontend\Orders\OrdersController@show']);

    });
});