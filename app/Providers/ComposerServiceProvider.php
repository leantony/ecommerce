<?php namespace App\Providers;

use App\Models\Cart;
use Illuminate\Support\ServiceProvider;
use View;

class ComposerServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        // all composers
        View::composers([
            'App\Http\ViewComposers\CategoryList' => ['layouts.frontend.master'],
            'App\Http\ViewComposers\BrandsList' => ['layouts.frontend.master'],
            'App\Http\ViewComposers\ShoppingCart' => ['frontend.*', 'auth.*', 'Shared.*'],
            'App\Http\ViewComposers\TopProducts' => ['frontend.*'],
            'App\Http\ViewComposers\NewProducts' => ['frontend.*'],
            'App\Http\ViewComposers\FeaturedLaptops' => ['frontend.*'],
            'App\Http\ViewComposers\FeaturedTablets' => ['frontend.*'],
            //'App\Http\ViewComposers\FeaturedSmartPhones' => ['frontend.*'],
            //'App\Http\ViewComposers\HomePageSlider' => ['frontend.index'],
        ]);

        View::composer('*', function ($view) {
            $view->with('is_logged_in', auth()->check())->with('auth_user', auth()->user());
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

}