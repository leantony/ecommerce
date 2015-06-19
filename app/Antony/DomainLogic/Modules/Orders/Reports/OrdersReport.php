<?php namespace app\Antony\DomainLogic\Modules\Orders\Reports;

use app\Antony\DomainLogic\Modules\Orders\OrdersRepository;

class OrdersReport extends OrdersRepository
{

    /**
     * @return mixed
     */
    public function viewTotalSales()
    {

        $orders = $this->all();

        return $this->getTotal($orders);
    }

    /**
     * @param $orders
     * @return int
     */
    protected function getTotal($orders)
    {
        if (empty($orders)) return 0;
        $sales_total = 0;
        foreach ($orders as $order) {

            $sales_total = $sales_total + array_get($order->data['cart'], 'grand_total');

        }

        return $sales_total;
    }

    /**
     * @param $user_id
     * @return mixed
     */
    public function viewTotalPurchasesByUser($user_id)
    {

        $orders = $this->whereHas('users', function ($user) use ($user_id) {

            $user->where('id', '=', $user_id);
        });

        return $this->getTotal($orders);
    }

    /**
     * @return mixed
     */
    public function viewTotalPurchasesForUsers()
    {

        $orders = $this->has('users', true);

        return $this->getTotal($orders);
    }

    /**
     * @return mixed
     */
    public function viewTotalPurchasesForGuests()
    {

        $orders = $this->has('guests', true);

        return $this->getTotal($orders);
    }

    /**
     * @param $date
     * @param bool $users
     * @return mixed
     */
    public function viewTotalSalesByDate($date, $users = true)
    {

        $orders = null;

        switch ($users) {

            case null:
                $orders = $this->where('created_at', '>', $date);
                break;
            case false:
                $orders = $this->has('guests', false)->where('created_at', '>=', $date)->get();
                break;
            case true:
                $orders = $this->has('users', false)->where('created_at', '>=', $date)->get();
                break;
        }

        return $this->getTotal($orders);
    }

    /**
     * @param $start
     * @param $end
     * @return mixed
     */
    public function viewTotalSalesByDateRange($start, $end)
    {

        $orders = $this->getModel()->where('created_at', '<=', $start)->where('delivered_at', '<=', $end);

        return $this->getTotal($orders);
    }
}