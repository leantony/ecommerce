<?php namespace app\Antony\DomainLogic\Modules\ShoppingCart\Formatters;

use app\Antony\DomainLogic\Contracts\ShoppingCart\Formatter;
use app\Antony\DomainLogic\Contracts\ShoppingCart\MoneyInterface;
use Money\Money;

class MoneyFormatter implements Formatter
{

    /**
     * @var array
     */
    private static $currencies;

    /**
     * Create a new Money Formatter
     *
     * @param string $locale
     *
     */
    public function __construct($locale = null)
    {
        if (!isset(static::$currencies)) {
            static::$currencies = json_decode(file_get_contents(__DIR__ . '/currencies.json'));
        }
    }

    /**
     * Format an input to an output
     *
     * @param mixed $value
     *
     * @return mixed
     */
    public function format($value)
    {
        if ($value instanceOf MoneyInterface) {
            $value = $value->toMoney();
        }

        $code = $this->code($value);

        $amount = $value->getAmount();

        return $code . ' ' . number_format($amount, 2, '.', ',');
    }

    /**
     * Get the currency ISO Code
     *
     * @param Money $value
     *
     * @return string
     */
    private function code(Money $value)
    {
        return $value->getCurrency()->getName();
    }
}
