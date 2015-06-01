<?php namespace app\Antony\DomainLogic\Contracts\ShoppingCart;

use Money\Money;

interface MoneyInterface
{

    /**
     * Return the object as an instance of Money
     *
     * @return Money
     */
    public function toMoney();
}