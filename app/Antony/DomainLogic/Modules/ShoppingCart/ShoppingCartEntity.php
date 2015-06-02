<?php namespace app\Antony\DomainLogic\Modules\ShoppingCart;

use app\Antony\DomainLogic\Modules\ShoppingCart\Base\Main\Basket;
use App\Models\Product;

class ShoppingCartEntity extends Basket
{

    /**
     * @param bool $json
     * @return array
     */
    public function displayShoppingCart($json = false)
    {
        if (!$this->cart_exists) {
            return null;
        }
        $cart_data = [];
        $products = [];
        if (is_null($this->products)) {

            $this->getShoppingCartData();

            return $this->displayShoppingCart();

        } else {

            foreach ($this->products as $product) {

                $qt = $product->pivot->quantity;
                $product->quantity($qt);

                $products[] = [
                    'name' => $product->name,
                    'sku' => $product->sku,
                    'id' => $product->id,
                    'image' => $product->image,
                    'price' => $product->price->getAmount(),
                    'price_after_discount' => $product->getPriceAfterDiscount(false),
                    'total_price' => $product->total()->getAmount(),
                    'quantity' => $qt,
                    'available' => $product->quantity,
                    'out_of_stock' => $product->quantity === 0,
                    'VAT' => $product->tax()->getAmount(),
                    'Shipping' => $product->delivery()->getAmount(),
                    'order_total' => $product->total()->getAmount()

                ];
            }

            $cart_data['cart'] = [
                'id' => $this->cart->id,
                'total_products' => $this->products->sum(function ($p) {
                    return $p->pivot->quantity;
                }),
                'product_count' => $this->products->count(),
                'currency' => config('site.currencies.default', 'KES'),
                'shipping' => $this->getShippingSubTotal(false),
                'VAT' => $this->getCartTaxSubTotal(false),
                'basket_total' => $this->getCartSubTotal(false),
                'grand_total' => $this->getGrandTotal(false)
            ];

            $data = array_add($cart_data, 'products', $products);

            return $json ? json_encode($data) : $data;
        }

    }
}