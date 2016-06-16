<?php namespace app\Antony\DomainLogic\Modules\ShoppingCart\Traits;

use app\Antony\DomainLogic\Modules\Product\Traits\ProductReconciler;
use app\Antony\DomainLogic\Modules\ShoppingCart\Base\ShoppingCartReconciler;

trait ReconcilerTrait
{
    // include both the product and shopping cart reconciler classes
    use ProductReconciler, ShoppingCartReconciler;
}