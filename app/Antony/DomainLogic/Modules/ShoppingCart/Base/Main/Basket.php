<?php namespace app\Antony\DomainLogic\Modules\ShoppingCart\Base\Main;

use app\Antony\DomainLogic\Contracts\ShoppingCart\ShoppingCartContract;
use app\Antony\DomainLogic\Modules\Cookies\ShoppingCartCookie;
use app\Antony\DomainLogic\Modules\ShoppingCart\Base\ShoppingCartReconciler;
use app\Antony\DomainLogic\Modules\ShoppingCart\Base\ShoppingCartRepository;
use app\Antony\DomainLogic\Modules\ShoppingCart\Traits\ReconcilerTrait;
use app\Antony\DomainLogic\Modules\ShoppingCart\Traits\StoreShoppingCartUsingCookie;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Session\Store;
use Illuminate\Support\Collection;
use InvalidArgumentException;

class Basket implements ShoppingCartContract
{
    use StoreShoppingCartUsingCookie, ReconcilerTrait;

    /**
     * The shopping cart
     *
     * @var Cart
     */
    protected $cart;

    /**
     * The data in a shopping cart
     *
     * @var mixed
     */
    protected $data;

    /**
     * Specifies if a shopping cart exists
     *
     * @var boolean
     */
    protected $cart_exists;

    /**
     * The products in a shopping cart
     *
     * @var Collection
     */
    protected $products;

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
    protected $shoppingCartCookie;

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
     * @var Store
     */
    protected $session;

    /**
     * @param ShoppingCartRepository $cartRepository
     * @param ShoppingCartCookie $shoppingCartCookie
     */
    public function __construct(ShoppingCartRepository $cartRepository, ShoppingCartCookie $shoppingCartCookie, Store $session)
    {

        $this->cartRepository = $cartRepository;
        $this->shoppingCartCookie = $shoppingCartCookie;
        $this->session = $session;

        if (is_null($this->cart)) {
            $this->getShoppingCartData();
        }

    }

    /**
     * Get details about an existing shopping cart
     */
    public function getShoppingCartData()
    {

        $cart = $this->getShoppingCart(null);

        $this->cart = $cart;

        if (!empty($cart)) {

            // check the database
            $this->checkDbForExistingCart($cart);

            if ($this->cart_exists) {
                // pull all the products
                $this->products = $cart->products()->get();

            }

        }

    }

    /**
     * Checks the database for an already specified shopping cart
     *
     * @param $cart
     */
    protected function checkDbForExistingCart($cart)
    {
        $this->data = $this->cartRepository->find($cart->id, [], false, ['id']);

        if (is_null($this->data)) {

            $this->cart_exists = false;

        } else {

            $this->cart_exists = true;
        }

    }

    /**
     * Adds a product to an existing/new shopping cart
     * The shopping cart is created if it doesn't exist
     *
     * @param $product
     * @param $quantity
     * @return int
     */
    public function add($product, $quantity)
    {
        // get the quantity from the user
        $qt = $this->validateQuantity($quantity, $product);

        return $this->cart_exists ? $this->updateExistingCart($product, $qt) : $this->makeCart($product, $qt);

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

        // get the products quantity in the shopping cart
        if (!$this->cart_exists) {

            return 1;
        }
        $this->existing_quantity = $this->cartRepository->getExistingProductQuantity($this->cart, $product->id);

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
        // check if the product exists in the cart
        if ($this->existing_quantity === 0) {

            //dd($this->existing_quantity);
            $this->cart->products()->attach([$product->id], ['quantity' => $qt, 'cart_id' => $this->cart->id]);

            // persist the cart in storage
            $this->persistShoppingCart();

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

        if ($this->cart_exists) {

            $qt = !$this->quantity_checked ? $this->validateQuantity($new_quantity, $product) : $this->validated_quantity;

            // get the existing product qt
            $value = !$increments ? $qt : $this->existing_quantity + $new_quantity;

            // check for an overflow
            $value = $value > $product->quantity ? $product->quantity : $value;

            $this->cart->products()->updateExistingPivot($product->id, ['quantity' => $value]);

            return $increments ? $value : $qt;
        }

        throw new InvalidArgumentException("A cart does not exist. Please create one first");
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
        // cart does not exist, so we create it
        $this->cart = $this->cartRepository->add([]);

        if (is_null($this->cart)) {

            return static::ERROR;
        }
        // then we add the product to it
        $this->cart->products()->attach([$product->id], ['quantity' => $qt, 'cart_id' => $this->cart->id]);

        $this->persistShoppingCart();

        return static::PRODUCTS_ADDED;
    }

    /**
     * Retrieves products in a user's shopping cart
     *
     * @return \Illuminate\Database\Eloquent\Model|\Illuminate\Support\Collection|null|static
     */
    public function retrieveProductsInCart()
    {
        return empty($this->cart) ? null : (is_null($this->products) || $this->products->count() < 1 ? null : $this->data);

    }

    /**
     * Checks if a shopping cart has products
     *
     * @return bool
     */
    public function hasProducts()
    {
        if ($this->cart_exists) {
            return $this->products->count() > 0;
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
        foreach ($this->products as $product) {

            $this->removeProduct($product);
        }

        return $this->cart->products()->get()->count() === 0 ? static::CART_EMPTY : -1;
    }

    /**
     * Removes products from a users shopping cart
     *
     * @param $product
     * @return int
     */
    public function removeProduct($product)
    {
        $result = $this->cart->products()->detach($product->id);

        return $result === 0 ? -1 : $result;

    }

}