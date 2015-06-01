<?php namespace app\Antony\DomainLogic\Contracts\ShoppingCart;

use App\Models\Product;
use Money\Money;

interface Reconciler
{
    /**
     * Return the value of the Product
     *
     * @return Money
     *
     */
    public function value();

    /**
     * Return the discount of the Product
     *
     * @return Money
     */
    public function discount();

    /**
     * Return the delivery charge of the Product
     *
     * @return Money
     */
    public function delivery();

    /**
     * Return the tax of the Product
     *
     * @return Money
     */
    public function tax();

    /**
     * Return the subtotal of the Product
     *
     * @return Money
     */
    public function subtotal();

    /**
     * Return the total of the Product
     *
     * @return Money
     */
    public function total();
}
