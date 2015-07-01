<?php

namespace App\Http\Controllers\Frontend\Orders;

use app\Antony\DomainLogic\Modules\Orders\OrdersRepository;
use App\Http\Controllers\Controller;
use App\Http\Requests\Orders\SubmitOrderRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class OrdersController extends Controller
{
    /**
     * @var OrdersRepository
     */
    private $orders;

    /**
     * @param OrdersRepository $orders
     */
    public function __construct(OrdersRepository $orders)
    {
        $this->orders = $orders;

        $this->middleware('auth', ['except' => ['store', 'displayInvoice', 'printInvoice', 'completeOrder']]);

        $this->useOverlay = true;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $orders = $this->orders->displayUserOrders($request->user()->getAuthIdentifier());

        return view('frontend.orders.viewMyOrders', compact('orders'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param SubmitOrderRequest $orderRequest
     *
     * @return Response
     */
    public function store(SubmitOrderRequest $orderRequest)
    {
        // check if a user requested to create their account
        if ($orderRequest->has('create_account')) {

            return redirect()->route('checkout.createAccount', ['proceedTo' => $orderRequest->url()]);
        } else {

            $this->data = $this->orders->placeOrder($orderRequest->all());

            $this->setSuccessMessage("Your order was successful. Thank you for shopping with us. Please review your invoice below");

            return $this->handleRedirect($orderRequest, route(!is_null($orderRequest->user()) ? 'u.checkout.viewInvoice' : 'checkout.viewInvoice'));
        }

    }

    /**
     * @param Request $request
     * @param $order
     * @return \Illuminate\View\View
     */
    public function show(Request $request, $order)
    {
        $data = $this->orders->displaySpecificOrder($order->id);

        if ($data->count() === 0) {

            $this->setErrorMessage("No orders were found");
            return $this->handleErrorWithFlashMessage(null, route('myorders'));
        }

        $order = '';

        $cart_data = '';

        $user = auth()->user();

        foreach ($data as $orders) {

            $order = $orders;

            $cart_data = $orders->data;
        }

        return view('frontend.orders.view_order', compact('order', 'cart_data', 'user'));
    }

    /**
     * @return $this
     */
    public function displayInvoice()
    {

        $data = $this->orders->invoice_data();

        $order = array_get($data, '0');
        //$cart_data = array_get($data, '2');
        $user = array_get($data, '1');

        return view('frontend.orders.displayInvoice', compact('order', 'user'));
    }

    /**
     * @return Response
     */
    public function printInvoice()
    {
        return $this->featureUnavailable();
    }

    /**
     * The user will invoke this method, once they click the 'continue shopping' button after they make their order
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function completeOrder()
    {
        return $this->orders->complete();
    }

}
