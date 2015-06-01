<?php namespace app\Antony\DomainLogic\Contracts\ShoppingCart;

interface Formatter
{

    /**
     * Format an input to an output
     *
     * @param mixed $value
     *
     * @return mixed
     */
    public function format($value);

}