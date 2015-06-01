<?php namespace app\http\ViewComposers;

use App\Antony\DomainLogic\Modules\Composers\ViewComposer;
use app\Antony\DomainLogic\Modules\ShoppingCart\ShoppingCartEntity as MyCart;
use App\Models\Cart;
use Illuminate\View\View;

class ShoppingCart extends ViewComposer
{
    /**
     * output variable name
     *
     * @var string
     */
    protected $outputVariable = 'cart';

    /**
     * @param MyCart $repository
     */
    public function __construct(MyCart $repository)
    {
        $this->dataSource = $repository;
    }

    /**
     * compose the view
     *
     * @param View $view
     *
     * @return mixed
     */
    public function compose(View $view)
    {
        return $view->with($this->outputVariable, $this->getData());
    }

    /**
     * Gets the data to display in the view
     *
     * @return mixed
     */
    public function getData()
    {
        $data = $this->dataSource->displayShoppingCart();

        return $data;

    }
}