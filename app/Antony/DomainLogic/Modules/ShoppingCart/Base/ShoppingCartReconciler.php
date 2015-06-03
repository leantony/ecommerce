<?php namespace app\Antony\DomainLogic\Modules\ShoppingCart\Base;

use App\Models\Product;

trait ShoppingCartReconciler
{
    /**
     * Check if products is the shopping cart have a shipping cost
     *
     * @return bool
     */
    public function productShippingCostNotAvailable()
    {
        return format_money($this->getShippingSubTotal(false), true)->isZero();
    }

    /**
     * Returns the total shipping cost of all products in a user's shopping cart
     *
     * @param bool $format
     *
     * @return mixed
     */
    public function getShippingSubTotal($format = true)
    {

        $scope = $this;

        $sum = $this->getProducts()->sum(function ($p) use ($scope) {
            return $scope->setProduct($p)->quantity($scope->getSingleProductQuantity($p))->delivery()->getAmount();
        });

        return !$format ? $sum : format_money($sum);

    }

    /**
     * Allow us to get the quantity of a single product in a user's shopping cart
     * The query assumes presence of a pivot in the collection, so if the query fails, we just return 1
     *
     * @param Product $product
     *
     * @return int
     */
    public function getSingleProductQuantity(Product $product)
    {
        // access the pivot that came with the collection. Cart::with('products.carts')->where('id', .....
        // table cart_product has a quantity field, which we then access via the pivot
        $qt = $product->pivot->quantity;

        // If the query fails for some reason, just return 1
        return is_null($qt) ? 1 : $qt;
    }

    /**
     * Get the total value of all products in the user's shopping cart
     *
     * @param bool $format
     *
     * @return mixed
     */
    public function getCartSubTotal($format = true)
    {
        $scope = $this;

        $sum = $this->getProducts()->sum(function ($p) use ($scope) {
            return $scope->setProduct($p)->quantity($scope->getSingleProductQuantity($p))->total($p)->getAmount();
        });

        return !$format ? $sum : format_money($sum);
    }

    /**
     * @param bool $format
     *
     * @return mixed
     */
    public function getIntermediateCost($format = true)
    {
        $scope = $this;

        $sum = $this->getProducts()->sum(function ($p) use ($scope) {
            return $scope->setProduct($p)->quantity($scope->getSingleProductQuantity($p))->value($p)->add($scope->delivery($p))->getAmount();
        });

        return !$format ? $sum : format_money($sum);
    }

    /**
     * Get the total tax value of all products in the user's shopping cart
     *
     * @param bool $format
     *
     * @return mixed
     */
    public function getCartTaxSubTotal($format = true)
    {

        $scope = $this;

        $sum = $this->getProducts()->sum(function ($p) use ($scope) {
            return $scope->setProduct($p)->quantity($scope->getSingleProductQuantity($p))->tax($p)->getAmount();
        });

        return !$format ? $sum : format_money($sum);
    }

    /**
     * Calculates the grand total value of all products in a user's shopping cart
     *
     * @param bool $format
     *
     * @return mixed
     */
    public function getGrandTotal($format = true)
    {

        $scope = $this;

        $sum = $this->getProducts()->sum(function ($p) use ($scope) {
            return $scope->setProduct($p)->quantity($scope->getSingleProductQuantity($p))->total($p)->getAmount();
        });

        return !$format ? $sum : format_money($sum);
    }
}