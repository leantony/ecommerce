<?php namespace app\Antony\DomainLogic\Modules\ShoppingCart\Formatters;

use app\Antony\DomainLogic\Contracts\ShoppingCart\Formatter;
use app\Antony\DomainLogic\Contracts\ShoppingCart\Percentage;

class PercentFormatter implements Formatter
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
        if ($value instanceOf Percentage) {
            $value = $value->toPercent();
        }

        return $value->int() . '%';
    }
}
