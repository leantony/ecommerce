<?php namespace app\Antony\DomainLogic\Modules\ShoppingCart\Base\Main;

use app\Antony\DomainLogic\Contracts\ShoppingCart\ShoppingCartCache;
use app\Antony\DomainLogic\Contracts\ShoppingCart\ShoppingCartContract;
use app\Antony\DomainLogic\Modules\Cookies\ShoppingCartCookie;
use app\Antony\DomainLogic\Modules\ShoppingCart\Base\ShoppingCartRepository;
use app\Antony\DomainLogic\Modules\ShoppingCart\Traits\ReconcilerTrait;
use app\Antony\DomainLogic\Modules\ShoppingCart\Traits\SessionCache;
use app\Antony\DomainLogic\Modules\ShoppingCart\Traits\StoreShoppingCartUsingCookie;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Session\SessionInterface;
use Illuminate\Support\Collection;
use InvalidArgumentException;

abstract class Basket implements ShoppingCartContract, ShoppingCartCache
{
    use StoreShoppingCartUsingCookie, ReconcilerTrait, SessionCache;

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
     * @param ShoppingCartCookie $shoppingCartCookie
     */
    public function __construct(ShoppingCartRepository $cartRepository, ShoppingCartCookie $shoppingCartCookie)
    {

        $this->cartRepository = $cartRepository;
        $this->cookie = $shoppingCartCookie;
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
        // get the quantity from the user
        if (is_null($this->getCart())) {
            $quantity = $quantity > $product->quantity ? $product->quantity : $quantity;

            return $this->makeCart($product, $quantity);
        } elseif ($this->getCart()->exists()) {

            $qt = $this->validateQuantity($quantity, $product);

            return $this->updateExistingCart($product, $qt);
        }
        return $this->makeCart($product, $quantity);
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
        // clear the session cache completely
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

        $this->existing_quantity = $this->cartRepository->getExistingProductQuantity($this->getCart(), $product->id);

        // check for an overload
        $this->validated_quantity = $this->existing_quantity > $product->quantity ? $this->existing_quantity - $quantity : $quantity;

        return $this->validated_quantity;
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

        // check if the product exists in the cart. This will prevent adding duplicate products in the same basket
        if ($this->existing_quantity === 0) {

            //dd($this->existing_quantity);
            $this->getCart()->products()->attach([$product->id], ['quantity' => $qt, 'cart_id' => $this->getCart()->id]);

            // update the session
            $this->cacheProducts($this->getCart()->products()->get());

            return static::PRODUCTS_ADDED;

        }
        return $this->updateBasket($product, $qt, true);
    }

    /**
     * Updates the quantity of an existing product in the shopping cart. Returns the new Quantity
     *
     * @param $product
     * @param $new_quantity
     * @param bool $increments
     * @return int
     * @throws InvalidArgumentException
     */
    public function updateBasket($product, $new_quantity, $increments = false)
    {

        if ($this->getCart()->exists()) {

            // remove cached products
            $this->removeCachedProducts();

            // get the quantity
            $qt = !$this->quantity_checked ? $this->validateQuantity($new_quantity, $product) : $this->validated_quantity;

            // get the existing product qt
            $value = !$increments ? $qt : $this->existing_quantity + $new_quantity;

            // check for a quantity overflow, and rectify it
            $value = $value > $product->quantity ? $product->quantity : $value;

            // update the basket
            $this->getCart()->products()->updateExistingPivot($product->id, ['quantity' => $value]);

            // cache the products
            $this->cacheProducts($this->getCart()->products()->get());

            return $increments ? $value : $qt;
        }

        // aah just give up, for now
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

            $this->removeProduct($product);
        }

        // remove all cached products
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
        if (!$this->basketIsCached()) {
            return null;
        }
        $cart_data = [];
        $products = [];

        if (!empty($this->getProducts())) {

            foreach ($this->getProducts() as $product) {

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
                'id' => $this->getCart()->id,
                'total_products' => $this->getProducts()->sum(function ($p) {
                    return $p->pivot->quantity;
                }),
                'product_count' => $this->getProducts()->count(),
                'currency' => config('site.currencies.default', 'KES'),
                'shipping' => $this->getShippingSubTotal(false),
                'VAT' => $this->getCartTaxSubTotal(false),
                'basket_total' => $this->getCartSubTotal(false),
                'grand_total' => $this->getGrandTotal(false)
            ];

            $data = array_add($cart_data, 'products', $products);

            return $json ? json_encode($data) : $data;
        }

        return null;

    }

    /**
     * @return Collection|null
     */
    public function getProducts()
    {
        return $this->productsAreCached() ? $this->getCachedProducts() : null;
    }
}