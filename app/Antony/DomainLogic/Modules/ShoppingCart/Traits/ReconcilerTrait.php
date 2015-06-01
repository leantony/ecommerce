<?php namespace app\Antony\DomainLogic\Modules\ShoppingCart\Traits;

use app\Antony\DomainLogic\Modules\Product\Traits\ProductReconciler;
use app\Antony\DomainLogic\Modules\ShoppingCart\Base\ShoppingCartReconciler;

trait ReconcilerTrait
{

    use productReconciler, ShoppingCartReconciler;
}