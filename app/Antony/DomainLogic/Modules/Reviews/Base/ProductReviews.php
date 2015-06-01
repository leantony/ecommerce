<?php namespace app\Antony\DomainLogic\Modules\Reviews\Base;

use app\Antony\DomainLogic\Modules\DAL\Base\DataAccessLayer;
use app\Antony\DomainLogic\Modules\Reviews\ReviewsRepository;

class ProductReviews extends DataAccessLayer
{
    /**
     * @param ReviewsRepository $reviewsRepository
     */
    public function __construct(ReviewsRepository $reviewsRepository)
    {
        parent::__construct($reviewsRepository);

    }

    /**
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|null
     */
    public function get()
    {
        // TODO: Implement get() method.
    }
}