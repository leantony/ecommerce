<?php namespace app\Antony\DomainLogic\Modules\Product\Traits;

use Illuminate\Contracts\Auth\Authenticatable;

trait ProductReviewsTrait
{

    /**
     * Determine if a product is 'HOT'
     *
     * @return bool
     */
    public function isHot()
    {
        return $this->getAverageRating() >= config('site.reviews.hottest') & $this->getSingleProductReviewCount() >= config('site.reviews.count');
    }

    /**
     * Okay, this attempts to calculate the average rating of a product
     *
     * @return float
     *
     */
    public function getAverageRating()
    {
        // get the total unique stars given for this product
        $total = $this->reviews->unique()->fetch('stars')->sum();
        // count all unique reviews for this product
        $count = $this->getSingleProductReviewCount();
        // avoid division by 0
        if (empty($count)) {
            return 0;
        }

        return $total / $count;
    }

    /**
     * Allows us to get the total number of unique reviews for a particular product
     *
     * @return int|null
     */
    public function getSingleProductReviewCount()
    {
        return $this->reviews->unique()->count();
    }

    /**
     * Allows us to check if a product has been reviewed. just a wrapper around the getSingleProductReviewCount function
     *
     * @return bool
     */
    public function hasReviews()
    {
        return $this->getSingleProductReviewCount() > 0;
    }

    /**
     * sorts the product reviews by date, and returns them
     *
     * This is used in the single products page, to render the reviews. We don't need to display all of them,
     * so we grab a variable amount, default = 5
     *
     * @param Authenticatable $user
     * @param int $howMany
     *
     * @return mixed
     */
    public function grabReviews(Authenticatable $user = null, $howMany = 5)
    {
        if (is_null($user)) {

            return $this->reviews->take($howMany)->sortByDesc(function ($r) {
                return $r->stars;
            });
        } else {

            return $this->reviews->take($howMany)->sortByDesc(function ($r) {
                return $r->stars;
            })->filter(function ($data) use ($user) {
                return $data->user_id !== $user->getAuthIdentifier();
            });
        }

    }

    /**
     * @param Authenticatable $user
     *
     * @return mixed
     */
    public function grabAllReviews(Authenticatable $user = null)
    {
        if (is_null($user)) {
            return $this->reviews->sortByDesc(function ($r) {
                return $r->stars;
            }
            );
        } else {

            return $this->reviews->filter(function ($data) use ($user) {
                return $data->user_id !== $user->getAuthIdentifier();
            })->sortByDesc(function ($r) {
                return $r->stars;
            });
        }

    }
}