<?php namespace app\Antony\DomainLogic\Modules\ShoppingCart;

class Percent
{
    /**
     * @var int
     */
    private $value;

    /**
     * Create a new Percent
     *
     * @param int $value
     *
     */
    public function __construct($value)
    {
        $this->value = $value;
    }

    /**
     * Return the value as an int
     *
     * @return int
     */
    public function int()
    {
        return $this->value;
    }
}
