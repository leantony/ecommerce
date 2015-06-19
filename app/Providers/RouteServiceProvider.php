<?php namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Routing\Router;

class RouteServiceProvider extends ServiceProvider
{

    /**
     * This namespace is applied to the controller routes in your routes file.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @param  \Illuminate\Routing\Router $router
     *
     * @return void
     */
    public function boot(Router $router)
    {
        $router->model('brands', 'App\Models\Brand');
        $router->model('products', 'App\Models\Product');
        $router->model('categories', 'App\Models\Category');
        $router->model('subcategories', 'App\Models\SubCategory');
        $router->model('articles', 'App\Models\Article');
        $router->model('counties', 'App\Models\County');
        $router->model('orders', 'App\Models\Order');
        $router->model('users', 'App\Models\User');

        parent::boot($router);
    }

    /**
     * Define the routes for the application.
     *
     */
    public function map()
    {
        $this->loadRoutesFrom(app_path('Http/routes.php'));
        $this->loadRoutesFrom(app_path('Http/CustomRoutes/backend.php'));
    }

}
