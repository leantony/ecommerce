<?php namespace App\Http\Controllers\Backend;

use app\Antony\DomainLogic\Modules\Orders\Reports\OrdersReport as OrdersRepository;
use App\Http\Controllers\Controller;
use app\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use yajra\Datatables\Datatables;

class OrdersController extends Controller
{

    /**
     * @var OrdersRepository
     */
    private $ordersRepository;

    /**
     * @param OrdersRepository $ordersRepository
     */
    public function __construct(OrdersRepository $ordersRepository)
    {
        $this->ordersRepository = $ordersRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        //dd($orders = $this->ordersRepository->with(['users'])->has('users')->get());
        $totalSales = format_money($this->ordersRepository->viewTotalSales());

        if ($request->get('guest') == 1) {
            $salesToday = format_money($this->ordersRepository->viewTotalSalesByDate(Carbon::today(), false));

            $count = $this->ordersRepository->has('guests')->count();

            $guestSales = format_money($this->ordersRepository->viewTotalPurchasesForGuests());

            return view('backend.orders.guests', compact('totalSales', 'salesToday', 'guestSales', 'count'));
        }

        $salesToday = format_money($this->ordersRepository->viewTotalSalesByDate(Carbon::today()));

        $count = $this->ordersRepository->has('users')->count();

        $userSales = format_money($this->ordersRepository->viewTotalPurchasesForUsers());

        return view('backend.orders.users', compact('totalSales', 'salesToday', 'userSales', 'count'));
    }

    /**
     * @return mixed
     */
    public function getUserOrdersTable()
    {
        $orders = $this->ordersRepository->with(['users'])->has('users')->select('*');

        $data = Datatables::of($orders)->addColumn('details', function ($order) {

            return link_to(route('backend.orders.show', ['order' => $order->id]), 'details', ['data-target-model' => $order->id, 'class' => 'btn btn-xs btn-primary']);
        })->addColumn('quantity', function ($order) {
            return array_get($order->data['cart'], 'total_products');
        })->addColumn('price', function ($order) {
            return format_money(array_get($order->data['cart'], 'grand_total'));
        })->addColumn('delivered', function ($order) {
            return $order->delivered ? "Yes" : "Not Yet";
        })->addColumn('user', function ($order) {
            $f = $order->users->implode('first_name');
            $l = $order->users->implode('last_name');
            return beautify($f . ' ' . $l);
        })->addColumn('email', function ($order) {
            return $order->users->fetch('email');
        });

        return $data->make(true);
    }

    /**
     * @return mixed
     */
    public function getGuestsOrdersTable()
    {
        $orders = $this->ordersRepository->has('guests', false)->select('*');

        $data = Datatables::of($orders)->addColumn('details', function ($order) {
            return link_to(route('backend.orders.show', ['order' => $order->id]), 'details', ['data-target-model' => $order->id, 'class' => 'btn btn-xs btn-primary']);
        })->addColumn('quantity', function ($order) {
            return array_get($order->data['cart'], 'total_products');
        })->addColumn('price', function ($order) {
            return format_money(array_get($order->data['cart'], 'grand_total'));
        })->addColumn('delivered', function ($order) {
            return $order->delivered ? "Yes" : "Not Yet";
        })->addColumn('user', function ($order) {
            $f = $order->guests->implode('first_name');
            $l = $order->guests->implode('last_name');
            return beautify($f . ' ' . $l);
        })->addColumn('email', function ($order) {
            return $order->guests->fetch('email');
        });

        return $data->make(true);
    }

    /**
     * Display the specified resource.
     *
     * @param Order $order
     * @param Request $request
     * @return Response
     */
    public function show(Order $order, Request $request)
    {
        $data = $order->with([$request->get('guest') === 1 ? 'guests' : 'users'])->get();

        $order = null;
        foreach ($data as $order_) {

            $order = $order_;
        }

        return view('backend.orders.view', compact('order'));
    }
}
