<?php

Route::group(['prefix' => '', 'middleware' => 'http'], function () {

    // home page
    get('/', ['as' => 'home', 'uses' => 'Frontend\HomeController@index']);

    Route::group(['prefix' => 'help', 'namespace' => 'Shared'], function () {

        get('/', ['as' => 'help', 'uses' => 'HelpController@index']);
        // help & faq
        get('/faq', ['as' => 'faq', 'uses' => 'HelpController@displayFAQ']);
        // articles
        get('/article/{articles}', ['as' => 'help.article.view', 'uses' => 'HelpController@show']);
    });

    // info pages
    Route::group(['prefix' => 'info', 'namespace' => 'Frontend\Contacts'], function () {

        // requesting the about page
        get('about', ['as' => 'about', 'uses' => 'InfoController@getAbout']);

        // requesting the terms & conditions page
        get('termsofuse', ['as' => 'terms', 'uses' => 'InfoController@getTerms']);

        // requesting the contact page
        get('contact', ['as' => 'contact', 'uses' => 'InfoController@getContact']);

        // this will handle the action of a user sending a message to us. since the form is already by default on the page, we don't need a GET request
        post('contact', ['as' => 'contact.post', 'uses' => 'InfoController@postContactMessage', 'middleware' => ['msg.check']]);
    });

    // authentication
    Route::group(['prefix' => 'auth', 'namespace' => 'Shared'], function () {

        // login
        Route::group(['prefix' => 'login'], function () {

            // requesting the login page
            get('/', ['as' => 'login', 'uses' => 'AuthController@getLogin']);

            // posting to the login page, for credentials validation
            post('/', ['as' => 'login.verify', 'uses' => 'AuthController@postLogin']);

        });

        // OAUTH
        Route::group(['prefix' => 'oauth'], function () {

            // API login
            get('/', ['as' => 'auth.loginUsingAPI', 'uses' => 'AuthController@apiAuth', 'middleware' => 'api.authenticate']);

            // account creation. Requires that a valid user was returned by the API
            get('/register', ['as' => 'auth.fill', 'uses' => 'AuthController@getMiniRegistrationForm', 'middleware' => 'user.found']);
            post('/register', ['as' => 'auth.fill.post', 'uses' => 'AuthController@createAccountViaOAUTHData', 'middleware' => 'user.found']);

            // handle user verification via OAUTH
            get('/callback', ['as' => 'auth.getDataFromAPI', 'uses' => 'AuthController@handleOAUTHCallback']);

        });

        // registration
        Route::group(['prefix' => 'register'], function () {
            // display registration form
            get('/', ['as' => 'register', 'uses' => 'AuthController@getRegister']);

            // process user registration
            post('/', ['as' => 'registration.store', 'uses' => 'AuthController@postRegister']);
        });

        // logout
        get('logout', ['as' => 'logout', 'uses' => 'AuthController@getLogout']);

        // account activation
        get('/activate/{code}', ['as' => 'account.activate', 'uses' => 'AuthController@getActivate']);

        // confirming a user's password
        post('/confirm_password', ['as' => 'confirm_password', 'uses' => 'AccountController@confirmPassword', 'middleware' => ['auth']]);

        // password reset
        Route::group(['prefix' => 'password'], function () {

            // display email form for password reset. This isn't used entirely because displaying the form is done via a modal
            get('/reset', ['as' => 'password.reset', 'uses' => 'PasswordController@getEmail']);

            // verifying email
            post('/reset', ['as' => 'reset.postEmail', 'uses' => 'PasswordController@postEmail']);

            // display the form for resetting a password
            get('/new/{token}', ['as' => 'reset.start', 'uses' => 'PasswordController@getReset']);

            // save the new password
            post('/new', ['as' => 'reset.finish', 'uses' => 'PasswordController@postReset']);
        });


    });

    // usr account
    Route::group(['prefix' => "account", 'namespace' => 'Shared', 'middleware' => ['auth']], function () {

        // account customizations
        get('/', ['as' => 'myaccount', 'uses' => 'AccountController@index']);

        patch('/Info/contact', ['as' => 'account.info.contact.edit', 'uses' => 'AccountController@patchContacts']);

        patch('/Info/add', ['as' => 'account.info.addMore', 'uses' => 'AccountController@patchAccountAddingMoreDetails', 'middleware' => ['age.filter']]);

        patch('/Info/personal', ['as' => 'account.info.personal.edit', 'uses' => 'AccountController@patchAccount', 'middleware' => ['age.filter']]);

        patch('/Info/shipping', ['as' => 'account.info.shipping.edit', 'uses' => 'AccountController@patchShipping']);

        patch('/password/new', ['as' => 'account.password.edit', 'uses' => 'AccountController@patchPassword']);

        delete('/delete', ['as' => 'account.delete.temporary', 'uses' => 'AccountController@deleteAccount']);

    });

    // shop
    Route::group(['prefix' => 'shop', 'namespace' => 'Frontend\Inventory'], function(){
        // categories
        Route::group(['prefix' => 'categories'], function () {
            // listing categories. sort of sitemaping, or whatever
            get('/', ['as' => 'allCategories', 'uses' => 'CategoriesController@index']);

            // display all products in the category, regardless of sub-category
            get('/{categories}', ['as' => 'categories.shop', 'uses' => 'CategoriesController@show']);
        });

        // subcategories
        Route::group(['prefix' => 'sub-categories'], function () {

            get('/', ['as' => 'allSubCategories', 'uses' => 'SubCategoriesController@index']);

            get('/{subcategories}', ['as' => 'subcategories.shop', 'uses' => 'SubCategoriesController@show']);
        });

        // products
        Route::group(['prefix' => 'products'], function () {

            get('/', ['as' => 'allProducts', 'uses' => 'ProductsController@index']);

            get('/{products}', ['as' => 'product.view', 'uses' => 'ProductsController@show']);

        });

        // brands
        Route::group(['prefix' => 'brands'], function () {

            get('/', ['as' => 'allBrands', 'uses' => 'BrandsController@index']);

            get('/{brands}', ['as' => 'brands.shop', 'uses' => 'BrandsController@show']);
        });
    });

    // search
    Route::group(['prefix' => 'search', 'namespace' => 'Frontend\Search'], function () {
        // handles a search request from the client
        get('/', ['as' => 'client.search', 'uses' => 'SearchController@show']);
    });

    // basket
    Route::group(['prefix' => 'basket', 'namespace' => 'Frontend\Basket'], function () {

        get('/', ['as' => 'cart.index', 'uses' => 'CartController@index']);
        // adding a product to the cart
        post('add/product/{products}', ['as' => 'cart.add', 'uses' => 'CartController@store']);
        // listing all products in the cart
        get('/view', ['as' => 'cart.view', 'uses' => 'CartController@view']);
        // add a product to an existing cart
        patch('/update/add/{products}', ['as' => 'cart.update', 'uses' => 'CartController@update']);

        delete('/update/remove/{products}/remove', ['as' => 'cart.update.remove', 'uses' => 'CartController@removeProduct']);

        delete('/update/removeAll', ['as' => 'cart.removeAllProducts', 'uses' => 'CartController@removeAllProducts']);

        // a users shopping cart
        Route::group(['prefix' => '', 'middleware' => ['auth']], function () {

            get('/', ['as' => 'mycart', 'uses' => 'CartController@getMine']);
        });
    });

    // reviews
    Route::group(['prefix' => 'reviews', 'namespace' => 'Frontend\Reviews', 'middleware' => ['auth']], function () {

        post('/save/product/{productID}', ['as' => 'product.reviews.store', 'uses' => 'ReviewsController@store', 'middleware' => 'reviews.check']);

        patch('/edit/{id}', ['as' => 'product.reviews.update', 'uses' => 'ReviewsController@update']);
    });

    get('checkout/begin', ['as' => 'checkout.auth', 'uses' => 'Frontend\Checkout\GuestCheckoutController@auth', 'middleware' => ['cart.check']]);

    // checking out as a guest user
    Route::group(['prefix' => 'checkout/guest', 'namespace' => 'Frontend\Checkout', 'middleware' => ['cart.check', 'checkout.guest']], function () {

        get('/', ['as' => 'checkout.step1', 'uses' => 'GuestCheckoutController@guestInfo']);

        post('/aboutMe', ['as' => 'checkout.step1.store', 'uses' => 'GuestCheckoutController@postGuestInfo']);

        patch('/aboutMe', ['as' => 'checkout.step1.edit', 'uses' => 'GuestCheckoutController@editShippingAddress']);

        get('/shipping', ['as' => 'checkout.step2', 'uses' => 'GuestCheckoutController@shipping']);

        patch('/shipping', ['as' => 'checkout.step2', 'uses' => 'GuestCheckoutController@patchShipping']);

        get('/payment', ['as' => 'checkout.step3', 'uses' => 'GuestCheckoutController@payment']);

        post('/payment', ['as' => 'checkout.step3.post', 'uses' => 'GuestCheckoutController@storePayment']);

        get('/reviewOrder', ['as' => 'checkout.step4', 'uses' => 'GuestCheckoutController@reviewOrder']);

        get('/createAccount', ['as' => 'checkout.createAccount', 'uses' => 'GuestCheckoutController@getCreateAccount']);

        post('/createAccount', ['as' => 'checkout.createAccount.post', 'uses' => 'GuestCheckoutController@createAccount']);

    });

    // orders for a guest user
    Route::group(['prefix' => 'checkout/guest/orders', 'namespace' => 'Frontend\Orders', 'middleware' => ['cart.check', 'checkout.guest']], function(){
        post('/placeOrder', ['as' => 'checkout.submitOrder', 'uses' => 'OrdersController@store']);

        get('/viewInvoice', ['as' => 'checkout.viewInvoice', 'uses' => 'OrdersController@displayInvoice', 'middleware' => ['orders.verify']]);

        get('/invoice/pdf', ['as' => 'checkout.viewInvoice.pdf', 'uses' => 'OrdersController@printInvoice', 'middleware' => ['orders.verify']]);

        get('/complete', ['as' => 'order.finished', 'uses' => 'OrdersController@completeOrder', 'middleware' => ['orders.verify']]);
    });

    // checking out as a normal authenticated user
    Route::group(['prefix' => 'checkout', 'namespace' => 'Frontend\Checkout', 'middleware' => ['cart.check', 'checkout.user']], function () {

        get('/', ['as' => 'u.checkout.step2', 'uses' => 'AuthUserCheckoutController@index']);

        patch('/shipping', ['as' => 'u.checkout.step2.patch', 'uses' => 'AuthUserCheckoutController@shipping']);

        get('/payment', ['as' => 'u.checkout.step3', 'uses' => 'AuthUserCheckoutController@payment']);

        post('/payment', ['as' => 'u.checkout.step3.post', 'uses' => 'AuthUserCheckoutController@storePayment']);

        get('/reviewOrder', ['as' => 'u.checkout.step4', 'uses' => 'AuthUserCheckoutController@reviewOrder']);


    });

    //
    Route::group(['prefix' => 'checkout/orders', 'namespace' => 'Frontend\Orders', 'middleware' => ['cart.check', 'checkout.user']], function(){
        get('/viewInvoice', ['as' => 'u.checkout.viewInvoice', 'uses' => 'OrdersController@displayInvoice', 'middleware' => ['orders.verify']]);

        get('/invoice/pdf', ['as' => 'u.checkout.viewInvoice.pdf', 'uses' => 'OrdersController@printInvoice', 'middleware' => ['orders.verify']]);

        post('/placeOrder', ['as' => 'u.checkout.submitOrder', 'uses' => 'OrdersController@store']);

        get('/complete', ['as' => 'u.order.finished', 'uses' => 'OrdersController@completeOrder', 'middleware' => ['orders.verify']]);
    });
    // users orders
    Route::group(['prefix' => 'myorders', 'namespace' => 'Frontend\Orders', 'middleware' => ['auth', 'orders.verify']], function () {

        get('/', ['as' => 'myorders', 'uses' => 'OrdersController@index']);

        get('/{orders}', ['as' => 'viewOrder', 'uses' => 'OrdersController@show']);

    });
});