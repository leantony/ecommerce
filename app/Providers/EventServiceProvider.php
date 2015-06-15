<?php namespace App\Providers;

use App\Antony\DomainLogic\Modules\Images\ImageProcessor;
use App\Events\PasswordResetWasRequested;
use App\Events\UserWasRegistered;
use App\Listeners\Events\SendPasswordResetEmail;
use App\Listeners\Events\SendRegistrationEmail;
use App\ModelObservers\ProductBrandObserver;
use App\ModelObservers\ProductObserver;
use App\ModelObservers\UserObserver;
use App\Models\Brand;
use App\Models\Cart;
use App\Models\Category;
use App\Models\Product;
use App\Models\SubCategory;
use App\Models\User;
use Illuminate\Contracts\Events\Dispatcher as DispatcherContract;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{

    /**
     * The event handler mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'event.name' => [
            'EventListener',
        ],
        // user registration event
        UserWasRegistered::class => [
            SendRegistrationEmail::class
        ],
        // password reset event
        PasswordResetWasRequested::class => [
            SendPasswordResetEmail::class
        ],

    ];

    /**
     * Register any other events for your application.
     *
     * @param  \Illuminate\Contracts\Events\Dispatcher $events
     *
     * @return void
     */
    public function boot(DispatcherContract $events)
    {
        parent::boot($events);

        // register custom model observers
        Product::observe(new ProductObserver(new ImageProcessor()));

        Brand::observe(new ProductBrandObserver(new ImageProcessor()));

        User::observe(new UserObserver(new ImageProcessor()));
    }

}
