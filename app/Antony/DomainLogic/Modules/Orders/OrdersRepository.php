<?php namespace app\Antony\DomainLogic\Modules\Orders;

use app\Antony\DomainLogic\Contracts\Invoice\InvoiceContract;
use app\Antony\DomainLogic\Contracts\Orders\ProductOrderContract;
use app\Antony\DomainLogic\Modules\Cookies\CheckOutCookie;
use app\Antony\DomainLogic\Modules\Cookies\OrderCookie;
use app\Antony\DomainLogic\Modules\DAL\EloquentRepository;
use app\Antony\DomainLogic\Modules\Guests\GuestRepository;
use app\Antony\DomainLogic\Modules\Invoices\base\InvoiceRepository;
use app\Antony\DomainLogic\Modules\Invoices\InvoicingTrait;
use app\Antony\DomainLogic\Modules\ShoppingCart\Base\Main\Basket;
use app\Models\Order;
use Illuminate\Container\Container;

class OrdersRepository extends EloquentRepository implements ProductOrderContract, InvoiceContract
{

    // create invoices
    use InvoicingTrait;

    /**
     * @var Order
     */
    protected $order;

    /**
     * @var Basket
     */
    protected $shoppingCart;

    /**
     * @var GuestRepository
     */
    protected $checkoutCookie;

    /**
     * @var InvoiceRepository
     */
    protected $invoiceRepository;

    /**
     * @var OrderCookie
     */
    protected $orderCookieData;

    /**
     * @var OrderCookie
     */
    private $orderCookie;

    /**
     * @param Container $container
     * @param Basket $shoppingCart
     * @param CheckOutCookie $checkoutCookie
     * @param InvoiceRepository $invoiceRepository
     * @param OrderCookie $orderCookie
     */
    public function __construct(Container $container, Basket $shoppingCart, CheckOutCookie $checkoutCookie, InvoiceRepository $invoiceRepository, OrderCookie $orderCookie)
    {
        parent::__construct($container);

        $this->shoppingCart = $shoppingCart;
        $this->checkoutCookie = $checkoutCookie;
        $this->invoiceRepository = $invoiceRepository;
        $this->orderCookie = $orderCookie;

    }

    /**
     * Specify the Model class name
     *
     * @return mixed
     */
    public function model()
    {
        return Order::class;
    }

    /**
     * Display a user's order
     *
     * @param $order_id
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function displaySpecificOrder($order_id)
    {
        $data = $this->with(['products'])->whereHas('users', function ($u) {
            $u->where('user_id', '=', auth()->user()->getAuthIdentifier());
        })->where('id', $order_id)->get();

        $this->invoice_data = $data;

        return $data;
    }

    /**
     * @param $user_id
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function displayUserOrders($user_id)
    {
        $data = $this->with(['products'])->whereHas('users', function ($u) use ($user_id) {
            $u->where('user_id', '=', $user_id);
        })->get();

        return $data;
    }

    /**
     * @param $guest_id
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function displayGuestOrders($guest_id)
    {
        return $this->with(['guests' => function ($u) use ($guest_id) {
            $u->where('guest_id', $guest_id);
        }, 'products'])->get();
    }

    /**
     * @param $data
     *
     * @return Order|mixed|static
     */
    public function placeOrder($data)
    {
        $cart_data = $this->shoppingCart->displayShoppingCart();

        $data = [
            'cart_data' => $cart_data,
            'user_data' => array_get($this->checkoutCookie->fetch()->get(), 'data'),
            'products_data' => $this->shoppingCart->retrieveProductsInCart(),
        ];

        $this->order = $this->add($data);

        $this->saveOrderInCookie(null);

        return $this->order;
    }

    /**
     * @param $data
     *
     * @return static
     */
    public function add($data)
    {
        $this->model->creating(function ($order) use ($data) {

            $order->id = $this->generateOrderId();

            // add the shopping cart data
            $order->data = array_get($data, 'cart_data');
        });

        $this->performSync($data);

        $order = parent::add([]);

        return $order;
    }

    /**
     * @return string
     */
    public function generateOrderId()
    {
        return int_random();
    }

    /**
     * @param $data
     */
    public function performSync($data)
    {
        $products_data = array_get($data, 'products_data');

        $cart_data = array_get($data, 'cart_data');

        $user_data = array_get($data, 'user_data');

        // handle the model created event
        $this->model->created(function ($order) use ($products_data, $user_data, $cart_data) {

            foreach ($cart_data['products'] as $_product) {
                // add each product to the join table => order_product
                $products_data->each(function ($product) use ($order, $_product, $products_data) {

                    $order->products()->attach([$product->id], ['quantity' => $_product['quantity']], [$order->id]);

                    // decrement product quantity
                    $product->quantity = $product->quantity - $_product['quantity'];

                    $product->save();

                });
            }


            // add user/guest info to the join table => order_user
            if (!is_null(auth()->user())) {
                // user
                $order->users()->attach([auth()->user()->getAuthIdentifier()], ['order_id' => $order->id]);
            } else {

                // guest
                $order->guests()->attach([$user_data->id], ['order_id' => $order->id]);
            }
        });
    }

    /**
     * @param $data
     *
     * @return void
     */
    public function saveOrderInCookie($data)
    {
        $this->orderCookie->cookie->queue($this->orderCookie->name, $this->order->id, $this->orderCookie->timespan);
    }

    /**
     * @param $order_id
     *
     * @return mixed
     */
    public function cancel($order_id)
    {
        // TODO: Implement cancel() method.
    }

    /**
     * @param $data
     */
    public function setDataForInvoice($data)
    {
        $this->invoice_data = $data;
    }

    /**
     * @param null $order_id
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getOrderData($order_id = null)
    {
        $data = $this->getFirstBy('id', '=', is_null($order_id) ? $this->order->id : $order_id, ['guests', 'users.county', 'products'])->get();

        return $data;
    }

    /**
     * @return mixed|\Symfony\Component\HttpFoundation\Cookie
     */
    public function destroyOrderCookie()
    {

        return $this->orderCookie->destroy();
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function complete()
    {
        $this->emptyCart();

        $this->orderCookie->cookie->queue($this->orderCookie->name, -1);

        return redirect()->route('home');
    }

    /**
     * @return int
     */
    public function emptyCart()
    {
        // empty the shopping cart
        return $this->shoppingCart->makeItEmpty();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    protected function getDataForInvoice()
    {
        $this->invoice_data = $this->with([is_null(auth()->user()) ? 'guests' : 'users', 'products'])->where('id', '=', $this->getCookieData())->get();

        return $this->invoice_data;
    }

    /**
     * @return array|null
     */
    public function getCookieData()
    {
        $cookieData = $this->orderCookie->fetch()->get();

        $this->orderCookieData = $cookieData;

        return $this->orderCookieData;
    }
}