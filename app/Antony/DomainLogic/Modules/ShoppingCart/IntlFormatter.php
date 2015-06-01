<?php namespace app\Antony\DomainLogic\Modules\ShoppingCart;

use app\Antony\DomainLogic\Contracts\ShoppingCart\Formatter;
use NumberFormatter;

class IntlFormatter implements Formatter
{
    /**
     * @var NumberFormatter
     */
    private $numberFormatter;

    /**
     * @param NumberFormatter $numberFormatter
     */
    public function __construct(NumberFormatter $numberFormatter)
    {
        $this->numberFormatter = $numberFormatter;
    }

    /**
     * @param  string $locale
     *
     * @return static
     */
    public static function fromLocale($locale)
    {
        return new static(
            new NumberFormatter(
                $locale,
                NumberFormatter::CURRENCY
            )
        );
    }

    /**
     * @param mixed $money
     *
     * @return string
     */
    public function format($money)
    {
        return $this->numberFormatter->formatCurrency(
            $money->getConvertedAmount(),
            $money->getCurrency()->getCurrencyCode()
        );
    }
}