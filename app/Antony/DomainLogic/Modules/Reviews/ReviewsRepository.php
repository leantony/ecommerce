<?php namespace app\Antony\DomainLogic\Modules\Reviews;

use app\Antony\DomainLogic\Modules\DAL\EloquentRepository;
use App\Models\Review;

class ReviewsRepository extends EloquentRepository
{

    /**
     * @param $data
     *
     * @return mixed
     */
    public function add($data)
    {
        // authenticated user
        $authUser = auth()->user();

        $productID = array_pull($data, 'product_id');

        // associate the review to a product and the currently logged in user
        $this->model->creating(function ($r) use ($productID, $authUser) {

            $r->product_id = $productID;

            $r->user_id = $authUser->getAuthIdentifier();
        });

        return parent::add($data);
    }

    /**
     * Specify the Model class name
     *
     * @return mixed
     */
    public function model()
    {
        return Review::class;
    }
}