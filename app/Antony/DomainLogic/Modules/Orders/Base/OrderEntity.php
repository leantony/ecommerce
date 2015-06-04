<?php namespace app\Antony\DomainLogic\Modules\Orders\Base;

use app\Antony\DomainLogic\Contracts\Invoice\InvoiceContract;
use app\Antony\DomainLogic\Contracts\Orders\ProductOrderContract;
use app\Antony\DomainLogic\Modules\Cookies\CheckOutCookie;
use app\Antony\DomainLogic\Modules\Cookies\OrderCookie;
use app\Antony\DomainLogic\Modules\DAL\Base\DataAccessLayer;
use app\Antony\DomainLogic\Modules\Guests\GuestRepository;
use app\Antony\DomainLogic\Modules\Invoices\base\InvoiceRepository;
use app\Antony\DomainLogic\Modules\Invoices\InvoicingTrait;
use app\Antony\DomainLogic\Modules\Orders\OrdersRepository;
use app\Antony\DomainLogic\Modules\ShoppingCart\ShoppingCartEntity;
use app\Models\Order;

class OrderEntity extends DataAccessLayer implements ProductOrderContract, InvoiceContract
{
    // create invoices
    use InvoicingTrait;

    /**
     * @var Order
     */
    protected $order;

    /**
     * @var ShoppingCartEntity
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
     * @param OrdersRepository $OrdersRepository
     * @param ShoppingCartEntity $shoppingCart
     * @param CheckOutCookie $checkoutCookie
     */
    public function __construct(OrdersRepository $OrdersRepository, ShoppingCartEntity $shoppingCart, CheckOutCookie $checkoutCookie, InvoiceRepository $invoiceRepository, OrderCookie $orderCookie)
    {

        $this->repository = $OrdersRepository;
        $this->shoppingCart = $shoppingCart;
        $this->checkoutCookie = $checkoutCookie;
        $this->invoiceRepository = $invoiceRepository;
        $this->orderCookie = $orderCookie;
    }

    /**
     * Ok, this presents a commonly used implementation of a SELECT procedure
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|null
     */
    public function get()
    {
        // display all orders in the system
        return $this->repository->paginate(['users', 'products']);
    }

    /**
     * Display a user's order
     *
     * @param $order_id
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function displaySpecificOrder($order_id)
    {
        $data = $this->repository->with(['products'])->whereHas('users', function ($u) {
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
        $data = $this->repository->with(['products'])->whereHas('users', function ($u) use ($user_id) {
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
        return $this->repository->with(['guests' => function ($u) use ($guest_id) {
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

        $this->order = $this->repository->add($data);

        $this->saveOrderInCookie(null);

        return $this->order;
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
        $data = $this->repository->getFirstBy('id', '=', is_null($order_id) ? $this->order->id : $order_id, ['guests', 'users.county', 'products'])->get();

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
     * @return int
     */
    public function emptyCart()
    {
        // empty the shopping cart
        return $this->shoppingCart->makeItEmpty();
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
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    protected function getDataForInvoice()
    {
        $this->invoice_data = $this->repository->with([is_null(auth()->user()) ? 'guests' : 'users', 'products'])->where('id', '=', $this->getCookieData())->get();

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