<?php namespace app\http\ViewComposers;

use App\Antony\DomainLogic\Modules\Composers\ViewComposer;
use app\Antony\DomainLogic\Modules\ShoppingCart\Base\Main\Basket as ShoppingCartEntity;
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
     * @param ShoppingCartEntity $entity
     */
    public function __construct(ShoppingCartEntity $entity)
    {
        $this->dataSource = $entity;
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