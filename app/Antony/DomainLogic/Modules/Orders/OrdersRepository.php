<?php namespace app\Antony\DomainLogic\Modules\Orders;

use app\Antony\DomainLogic\Modules\DAL\EloquentRepository;
use app\Models\Order;

class OrdersRepository extends EloquentRepository
{

    protected $orderID;

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

        $this->orderID = $order->id;

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
        $cartData = array_get($data, 'cart_data');

        $userData = array_get($data, 'user_data');

        // handle the model created event
        $this->model->created(function ($order) use ($cartData, $userData) {

            // add each product to the join table => order_product
            $cartData->products->each(function ($product) use ($order, $cartData) {

                $order->products()->attach([$product->id], ['quantity' => $cartData->getSingleProductQuantity($product)], [$order->id]);

                // decrement product quantity
                $product->quantity = $product->quantity - $cartData->getSingleProductQuantity($product);

                $product->save();

            });

            // add user/guest info to the join table => order_user
            if (!is_null(auth()->user())) {
                // user
                $order->users()->attach([auth()->user()->getAuthIdentifier()], ['order_id' => $order->id]);
            } else {

                // guest
                $order->guests()->attach([$userData->id], ['order_id' => $order->id]);
            }
        });
    }

    /**
     * Specify the Model class name
     *
     * @return mixed
     */
    public function model()
    {
        return 'App\Models\Order';
    }
}