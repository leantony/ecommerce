<?php
/* ========================================
    ADMINISTRATIVE ROUTES SECTION
   ========================================
*/

// authentication
Route::group(['prefix' => 'backend', 'middleware' => ['backend-access']], function () {

    get('login', ['as' => 'backend.login', 'uses' => 'Shared\AuthController@getLogin']);
    post('login', ['as' => 'backend.login.post', 'uses' => 'Shared\AuthController@postLogin']);
    get('logout', ['as' => 'backend.logout', 'uses' => 'Shared\AuthController@getLogout']);
    // display email form for password reset. This isn't used entirely because displaying the form is done via a modal
    get('/reset_password', ['as' => 'b.password.reset', 'uses' => 'Shared\PasswordController@getEmail']);
});

/*
 * Backend routes. all restful
 *
 * The following middleware filters are used, for the backend
 * ============================================
 * https, authentication, access, authorization
 * ============================================
 * https: enforces backend access via https
 * access: controls access to the backend via IP checking
 * authentication: enforces backend login
 * authorization: checks the roles of the authenticating user, for a match
 *
 * */
Route::group(['prefix' => 'backend', 'middleware' => ['backend-access', 'auth.backend', 'backend-authorization']], function () {

    // backend home page
    get('/', ['as' => 'backend', 'uses' => 'Backend\HomeController@index']);

    // roles and permissions
    Route::group(['prefix' => 'security'], function () {

        // roles
        resource('roles', 'Backend\Security\RolesController');

        // permissions
        resource('permissions', 'Backend\Security\PermissionsController');

        // access control. defining permissions used by roles, and users assigned this roles
        Route::group(['prefix' => 'access-control'], function () {
            resource('roles', 'Backend\Security\UserRolesController');
        });

    });

    // other user's accounts
    Route::group(['prefix' => 'accounts'], function () {

        patch('/resetPassword/{user_id}', ['as' => 'useraccount.password.edit', 'uses' => 'Shared\AccountController@patchAnotherUsersPassword']);
    });

    // counties
    resource('counties', 'Backend\Shipping\CountiesController');

    // products
    resource('products', 'Backend\Inventory\ProductsController');

    // help articles
    resource('articles', 'Backend\Articles\ArticlesController');

    // brands
    resource('brands', 'Backend\Inventory\BrandsController');

    // categories
    resource('categories', 'Backend\Inventory\CategoriesController');

    // categories
    resource('orders', 'Backend\Orders\OrdersController');

    // subcategories
    resource('subcategories', 'Backend\Inventory\SubCategoriesController');

    // users
    resource('users', 'Backend\Users\UsersController');

    // reports
    Route::group(['prefix' => 'reports'], function(){

        get('/sales', ['as' => 'reports.sales', 'uses' => 'Backend\Orders\OrdersController@getReport']);

    });

    // API data
    Route::group(['prefix' => 'api'], function () {

        get('/counties/data', ['as' => 'counties.data', 'uses' => 'Backend\Shipping\CountiesController@getDataTable']);
        get('/articles/data', ['as' => 'articles.data', 'uses' => 'Backend\Articles\ArticlesController@getDataTable']);
        get('/users/data', ['as' => 'users.data', 'uses' => 'Backend\Users\UsersController@getDataTable']);
        get('/products/data', ['as' => 'products.data', 'uses' => 'Backend\Inventory\ProductsController@getDataTable']);
        get('/brands/data', ['as' => 'brands.data', 'uses' => 'Backend\Inventory\BrandsController@getDataTable']);
        get('/subcategories/data', ['as' => 'subcategories.data', 'uses' => 'Backend\Inventory\SubCategoriesController@getDataTable']);
        get('/categories/data', ['as' => 'categories.data', 'uses' => 'Backend\Inventory\CategoriesController@getDataTable']);
        get('/orders/data/users', ['as' => 'orders.data.users', 'uses' => 'Backend\Orders\OrdersController@getUserOrdersTable']);
        get('/orders/data/guests', ['as' => 'orders.data.guests', 'uses' => 'Backend\Orders\OrdersController@getGuestsOrdersTable']);
    });
});