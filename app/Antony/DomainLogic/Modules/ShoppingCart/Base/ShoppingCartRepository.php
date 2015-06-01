<?php namespace app\Antony\DomainLogic\Modules\ShoppingCart\Base;

use app\Antony\DomainLogic\Modules\DAL\EloquentRepository;
use App\Models\Cart;

class ShoppingCartRepository extends EloquentRepository
{

    /**
     * Defines if we should associate a cart to an authenticated user
     *
     * @var boolean
     */
    public $associate = false;


    /**
     * @param $data
     * @param $id
     *
     * @return EloquentRepository|\Illuminate\Database\Eloquent\Model
     */
    public function addIfNotExist($data, $id)
    {
        return parent::addIfNotExist($id, $data);
    }

    /**
     * Adds a shopping cart to the database
     *
     * @param $data
     *
     * @return static
     */
    public function add($data)
    {
        // get the authenticated user
        $authUser = auth()->user();

        $this->model->creating(function ($cart) use ($authUser) {
            $cart->id = $this->generateCartID();

            // if a user is logged in, then we will associate this cart to them
            $cart->user_id = $authUser === null ? null : $authUser->getAuthIdentifier();
        });

        $model = parent::add($data);

        return $model;
    }

    /**
     * @return string
     */
    public function generateCartID()
    {
        return str_random(20);
    }

    /**
     * Attempts to find a shopping cart, using the params provided
     * When association is set to true, once the cart is found it will be automatically linked to the authenticated user
     *
     * @param $id
     * @param array $relationships
     * @param bool $throwExceptionIfNotFound
     *
     * @return \Illuminate\Database\Eloquent\Model|\Illuminate\Support\Collection|null|static
     */
    public function find($id, $relationships = [], $throwExceptionIfNotFound = true, $columns = array('*'))
    {
        $data = parent::find($id, $relationships, $throwExceptionIfNotFound = false, $columns);

        if (auth()->check() & $this->associate & !is_null($data)) {

            // check if the cart already belong to this user
            if ($data->user_id === auth()->user()->getAuthIdentifier()) {

                return $data;
            }

            // associate the cart to the authenticated user
            $data->user()->associate(auth()->user());

            $data->update();
        }

        return $data;
    }

    /**
     * @param $cart
     * @param $product_id
     *
     * @return array
     */
    public function getExistingProductQuantity(Cart $cart, $product_id)
    {
        if (empty($cart)) {
            return 0;
        }

        $data = $cart->products()->get()->where('id', $product_id)->fetch('pivot')->implode('quantity');

        if (empty($data)) {
            return 0;
        }

        return (int)$data;
    }

    /**
     * Specify the Model class name
     *
     * @return mixed
     */
    public function model()
    {
        return 'App\Models\Cart';
    }
}