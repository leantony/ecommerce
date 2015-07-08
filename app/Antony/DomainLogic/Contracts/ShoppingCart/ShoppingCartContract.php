<?php namespace app\Antony\DomainLogic\Contracts\ShoppingCart;

use App\Models\Product;

interface ShoppingCartContract
{
    /**
     * Constant representing addition of a product to the shopping cart
     *
     * @var int
     */
    const PRODUCTS_ADDED = 1;

    /**
     * Constant representing a cart update
     *
     * @var int
     */
    const CART_UPDATED = 2;

    /**
     * Constant representing an error
     *
     * @var int
     */
    const ERROR = -1;

    /**
     * Constant representing an empty cart
     *
     * @var int
     */
    const CART_EMPTY = 3;

    /**
     * Allows a user to create a shopping cart
     *
     * @param $product
     *
     * @param $quantity
     * @return mixed
     */
    public function add($product, $quantity);

    /**
     * Validates the quantity entered by a user
     *
     * @param $quantity
     * @param Product $product
     * @return int
     */
    public function validateQuantity($quantity, Product $product);

    /**
     * Allows a user to view products in their shopping cart
     *
     * @return mixed
     */
    public function retrieveProductsInCart();

    /**
     * Removes all products from a shopping cart
     *
     * @return int The number of products remaining
     */
    public function makeItEmpty();

    /**
     * Allows a user to update their shopping cart
     *
     * @param $product
     *
     * @param $new_quantity
     * @param bool $increments
     * @return mixed
     */
    public function updateBasket($product, $new_quantity, $increments = false);

    /**
     * Allows a user to remove a product from their shopping cart
     *
     * @param $product
     *
     * @return mixed
     */
    public function removeProduct($product);

    /**
     * Check if a shopping cart has any products
     *
     * @return boolean
     */
    public function hasProducts();
}