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
     * Specify the Model class name
     *
     * @return mixed
     */
    public function model()
    {
        return 'App\Models\Order';
    }
}