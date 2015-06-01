<?php namespace app\Antony\DomainLogic\Contracts\Orders;

interface ProductOrderContract
{

    /**
     * Constant representing a cancelled order
     *
     * @var string
     */
    const ORDER_CANCELLED = 'order.cancelled';

    /**
     * Constant representing a successful order(product delivery)
     *
     * @var string
     */
    const ORDER_COMPLETED = 'order.completed';

    /**
     * @param $data
     *
     * @return mixed
     */
    public function placeOrder($data);

    /**
     * @param $order_id
     *
     * @return mixed
     */
    public function cancel($order_id);

    /**
     * @param $data
     *
     * @return mixed
     */
    public function saveOrderInCookie($data);
}