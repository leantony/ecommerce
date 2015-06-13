<?php
/* ========================================
    ADMINISTRATIVE ROUTES SECTION
   ========================================
*/

// authentication
Route::group(['prefix' => 'backend', 'middleware' => ['https', 'backend-access']], function () {

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
Route::group(['prefix' => 'backend', 'middleware' => ['https', 'backend-access', 'auth.backend', 'backend-authorization']], function () {

    // backend home page
    get('/', ['as' => 'backend', 'uses' => 'Backend\HomeController@index']);

    // roles and permissions
    Route::group(['prefix' => 'security'], function () {

        // roles
        resource('roles', 'Backend\RolesController');

        // permissions
        resource('permissions', 'Backend\PermissionsController');

        // access control. defining permissions used by roles, and users assigned this roles
        Route::group(['prefix' => 'access-control'], function () {
            resource('roles', 'Backend\UserRolesController');
        });

    });

    // counties
    resource('counties', 'Backend\CountiesController');

    // products
    resource('products', 'Backend\ProductsController');

    // help articles
    resource('articles', 'Backend\ArticlesController');

    // brands
    resource('brands', 'Backend\BrandsController');

    // categories
    resource('categories', 'Backend\CategoriesController');

    // subcategories
    resource('subcategories', 'Backend\SubCategoriesController');

    // users
    resource('users', 'Backend\UsersController');

    // API data
    Route::group(['prefix' => 'api'], function () {

        get('/counties/data', ['as' => 'counties.data', 'uses' => 'Backend\CountiesController@getDataTable']);
        get('/articles/data', ['as' => 'articles.data', 'uses' => 'Backend\ArticlesController@getDataTable']);
        get('/users/data', ['as' => 'users.data', 'uses' => 'Backend\UsersController@getDataTable']);
        get('/products/data', ['as' => 'products.data', 'uses' => 'Backend\ProductsController@getDataTable']);
    });
});