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
        parent::boot($router);

        $router->model('brand', 'App\Models\Brand');
        $router->model('product', 'App\Models\Product');
        $router->model('category', 'App\Models\Category');
        $router->model('subcategory', 'App\Models\SubCategory');
        $router->model('article', 'App\Models\Article');
        $router->model('county', 'App\Models\Article');
        $router->model('order', 'App\Models\Order');
        $router->model('user', 'App\Models\User');
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
