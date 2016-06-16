<?php namespace app\Antony\DomainLogic\Modules\ShoppingCart\Base\Main;

use app\Antony\DomainLogic\Contracts\ShoppingCart\ShoppingCartCache;
use app\Antony\DomainLogic\Contracts\ShoppingCart\ShoppingCartContract;
use app\Antony\DomainLogic\Modules\ShoppingCart\Base\ShoppingCartRepository;
use app\Antony\DomainLogic\Modules\ShoppingCart\Traits\ReconcilerTrait;
use app\Antony\DomainLogic\Modules\ShoppingCart\Traits\SessionCache;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Session\SessionInterface;
use Illuminate\Support\Collection;
use InvalidArgumentException;

class Basket implements ShoppingCartContract, ShoppingCartCache
{
    use ReconcilerTrait, SessionCache;

    /**
     * @var ShoppingCartRepository
     */
    protected $cartRepository;

    /**
     * The quantity of an existing product
     *
     * @var int
     */
    protected $existing_quantity;

    /**
     * @var
     */
    protected $cookie;

    /**
     * Specifies if we've validated the quantity
     *
     * @var boolean
     */
    protected $quantity_checked = false;

    /**
     * The validated quantity
     *
     * @var int
     */
    protected $validated_quantity;

    /**
     * @var SessionInterface
     */
    protected $session;

    /**
     * @param ShoppingCartRepository $cartRepository
     */
    public function __construct(ShoppingCartRepository $cartRepository)
    {
        $this->cartRepository = $cartRepository;
        $this->session = app('session');
    }

    /**
     * Adds a product to an existing/new shopping cart
     * The shopping cart is created if it does not exist
     *
     * @param $product
     * @param $quantity
     * @return int
     */
    public function add($product, $quantity)
    {
        // get the quantity from the user. 
        // This prevents the 0 quantity that gets inserted, when a cart is created for the first time
        $quantity = $this->validateQuantity($quantity, $product);

        if (is_null($this->getCart())) {

            return $this->makeCart($product, $quantity);

        } elseif ($this->getCart()->exists()) {

            return $this->updateExistingCart($product, $quantity);
        }
        return $this->makeCart($product, $quantity);
    }

    /**
     * Ensures that the quantity a user specifies is valid
     *
     * @param $quantity
     * @param Product $product
     * @return int
     */
    public function validateQuantity($quantity, Product $product)
    {
        // check if qt is 0, and default to 1
        $quantity = ctype_digit($quantity) & $quantity > 0 ? $quantity : 1;

        $this->existing_quantity = empty($this->getCart()) ? 1 : $this->cartRepository->getExistingProductQuantity($this->getCart(), $product->id);

        // check for an overload, ie if the existing quantity above exceeds the actual quantity of a product
        $this->validated_quantity = $this->existing_quantity > $product->quantity ? $this->existing_quantity - $quantity : $quantity;

        return $this->validated_quantity;
    }

    /**
     * @return Cart|null
     */
    public function getCart()
    {
        return $this->basketIsCached() ? $this->getCachedBasket() : null;
    }

    /**
     * Creates a shopping cart
     *
     * @param $product
     * @param $qt
     * @return int
     */
    protected function makeCart($product, $qt)
    {
        // clear the cache completely
        $this->emptyCache();

        // cart does not exist, so we create it
        $cart = $this->cartRepository->add([]);

        if (is_null($cart)) {

            return static::ERROR;
        }
        // put cart in the cache
        $this->cacheBasket($cart);

        // then we add the product to it
        $cart->products()->attach([$product->id], ['quantity' => $qt, 'cart_id' => $cart->id]);

        // cache the products
        $this->cacheProducts($cart->products()->get());

        return static::PRODUCTS_ADDED;
    }

    /**
     * Updates the quantity of an existing product in the shopping cart
     *
     * @param $product
     * @param $qt
     * @return int
     */
    protected function updateExistingCart($product, $qt)
    {
        // clear the products from the session
        $this->removeCachedProducts();

        // If the quantity is 0, then the product does not exist in the basket. So, we insert it
        // as a new product. This will prevent adding duplicate products in the same basket
        if ($this->existing_quantity === 0) {

            $this->getCart()->products()->attach([$product->id], ['quantity' => $qt, 'cart_id' => $this->getCart()->id]);

            // store the products in the cache. This way, even if a page reload is done,
            // the data is simply retrieved from the cache, without really making any DB round-trips
            $this->cacheProducts($this->getCart()->products()->get());

            return static::PRODUCTS_ADDED;

        }
        // The product exists, so we increment its quantity
        return $this->updateBasket($product, $qt, true);
    }

    /**
     * Updates the quantity of an existing product in the shopping cart. Returns the new Quantity
     *
     * @param $product
     * @param $new_quantity
     * @param bool $increments A products quantity in the basket can sometimes be updated, ie x=x+new_quantity,
     * or the value replaced entirely. This arg specifies that action
     * @return int
     * @throws InvalidArgumentException
     */
    public function updateBasket($product, $new_quantity, $increments = false)
    {
        // check if the basket exists in the database
        if ($this->getCart()->exists()) {

            // remove cached products
            $this->removeCachedProducts();

            // get the quantity
            $qt = !$this->quantity_checked ? $this->validateQuantity($new_quantity, $product) : $this->validated_quantity;

            // If we are to do an increment, then we add the user's quantity to the existing one. Else we use the user's quantity
            $value = !$increments ? $qt : $this->existing_quantity + $new_quantity;

            // Sometimes the quantity may 'overflow'. ie, exceed the one assigned to a product in the database
            // so, below, we mitigate that
            $value = $value > $product->quantity ? $product->quantity : $value;

            // update the basket
            $this->getCart()->products()->updateExistingPivot($product->id, ['quantity' => $value]);

            // cache the products
            $this->cacheProducts($this->getCart()->products()->get());

            // return the quantity that was updated
            return $increments ? $value : $qt;
        }

        // This can be enhanced later to create the cart instead of throwing an exception
        throw new InvalidArgumentException("A cart does not exist. Please create one first");
    }

    /**
     * Retrieves products in a user's shopping cart
     *
     * @return \Illuminate\Database\Eloquent\Model|\Illuminate\Support\Collection|null|static
     */
    public function retrieveProductsInCart()
    {
        return empty($this->getCachedBasket()) ? null : $this->getCachedProducts();

    }

    /**
     * Checks if a shopping cart has products
     *
     * @return bool
     */
    public function hasProducts()
    {
        if ($this->basketIsCached()) {
            return !is_null($this->getCachedProducts()) ? $this->getCachedProducts()->count() > 0 : false;
        }
        return false;
    }

    /**
     * Removes all products from a user's shopping cart
     *
     * @return int
     */
    public function makeItEmpty()
    {
        foreach ($this->getCachedProducts() as $product) {

            $this->getCart()->products()->detach($product->id);
        }

        // This method call will pull the cache key corresponding to the products stored
        $this->removeCachedProducts();

        return empty($this->getCachedProducts()) ? static::CART_EMPTY : -1;
    }

    /**
     * Removes products from a users shopping cart
     *
     * @param $product
     * @return int
     */
    public function removeProduct($product)
    {
        // clear the products from the cache
        $this->removeCachedProducts();

        $result = $this->getCart()->products()->detach($product->id);

        // cache the products in the cart
        $this->cacheProducts($this->getCart()->products()->get());

        return $result === 0 ? -1 : $result;

    }

    /**
     * Renders the shopping cart data as an array, or JSON
     *
     * @param bool $json
     * @return array|string
     */
    public function displayShoppingCart($json = false)
    {
        // check if the shopping cart exists in the cache. Since it is cached as soon as its created,
        // then a cache check would be fine
        if (!$this->basketIsCached()) {
            return null;
        }

        $products = [];

        // check for products in the cart
        if (!empty($this->getProducts())) {

            // get the products
            foreach ($this->getProducts() as $product) {

                // access the quantity of the product in the cart
                $qt = $product->pivot->quantity;
                // set the quantity of this product, to be used for the calculations
                $product->quantity($qt);

                // build the products array
                $products = $this->mergeProductData($product, $qt);
            }

            // build the shopping cart array
            $cart_data = $this->mergeCartData();

            // add products as a key to the cart data array
            $data = array_add($cart_data, 'products', $products);

            return $json ? json_encode($data) : $data;
        }

        // if there were no products, we return null
        return null;

    }

    /**
     * @return Collection|null
     */
    public function getProducts()
    {
        return $this->productsAreCached() ? $this->getCachedProducts() : null;
    }

    /**
     * Add cart info, and return it as an array
     * @return array
     */
    protected function mergeCartData()
    {
        $cart_data = [];
        $cart_data['cart'] = [
            'id' => $this->getCart()->id,
            // Get the sum of individual product quantities
            'total_products' => $this->getProducts()->sum(function ($p) {
                return $p->pivot->quantity;
            }),
            // Get the number of products in the basket, regardless of their quantities.
            'product_count' => $this->getProducts()->count(),
            'currency' => config('site.currencies.default', 'KES'),
            'shipping' => $this->getShippingSubTotal(false),
            'VAT' => $this->getCartTaxSubTotal(false),
            'basket_total' => $this->getCartSubTotal(false),
            'grand_total' => $this->getGrandTotal(false)
        ];
        return $cart_data;
    }

    /**
     * Add individual product data into an array, then return it
     * @param $product
     * @param $qt
     * @return array
     */
    protected function mergeProductData($product, $qt)
    {
        $products = [];
        array_push($products, [
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

        ]);
        return $products;
    }
}