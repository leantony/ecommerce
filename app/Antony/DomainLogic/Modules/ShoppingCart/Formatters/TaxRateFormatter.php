<?php namespace app\Antony\DomainLogic\Modules\ShoppingCart\Formatters;

use app\Antony\DomainLogic\Contracts\ShoppingCart\Formatter;

class TaxRateFormatter implements Formatter
{
    /**
     * Format an input to an output
     *
     * @param mixed $value
     *
     * @return mixed
     */
    public function format($value)
    {
        return $value->percentage() . '%';
    }
}
