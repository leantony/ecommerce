<?php namespace app\Antony\DomainLogic\Contracts\ShoppingCart;

use app\Antony\DomainLogic\Modules\ShoppingCart\Percent;

interface Percentage
{

    /**
     * Return the object as a Percent
     *
     * @return Percent
     */
    public function toPercent();
}