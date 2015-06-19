<?php namespace app\Antony\DomainLogic\Modules\User;

use App\Models\Cart;
use App\Models\Review;
use Carbon\Carbon;
use DateTime;

trait UserTrait
{
    /**
     * The minimum user's age allowed
     *
     * @var int
     */
    public $minAge = 18;

    /**
     * The maximum user's age allowed
     *
     * @var int
     */
    public $maxAge = 60;

    /**
     * Flag to indicate that the user passed the age test
     *
     * @var bool
     */
    public $passedAgeTest = false;

    /**
     * The shopping cart model
     *
     * @var Cart
     */
    protected $cart;

    /**
     * @return boolean
     */
    public function canAccessBackend()
    {
        return $this->hasRole([config('site.backend.allowedRoles', 'Administrator')]);
    }

    /**
     * Check if the logged in user has reviewed a product
     *
     * @param $productID
     *
     * @return bool
     */
    public function hasMadeProductReview($productID)
    {
        $data = Review::whereUserId($this->id)->whereProductId($productID)->get(['id']);

        return !$data->isEmpty();
    }

    /**
     * Get the logged in user's review of a product
     *
     * @param $productID
     *
     * @return mixed
     */
    public function retrieveUserReview($productID)
    {
        return Review::whereUserId($this->id)->Where('product_id', $productID)
            ->get()->unique();
    }

    /**
     * @return Cart|array|static[]
     */
    public function retrieveCart()
    {
        // get the shopping cart
        $this->cart = $this->cart->whereUserId($this->id)->get(['id']);

        return $this->cart;
    }

    /**
     * @return bool
     */
    public function hadShoppingCart()
    {
        return !empty($this->retrieveCart());
    }

    /**
     * Checks if a user has added extra data to their account
     *
     * @return int
     */
    public function hasAddedAccountData()
    {
        return $this->attributes_are_empty(['avatar', 'dob', 'gender'], 0);
    }

    /**
     * Check if a user is 'ready' to check out
     *
     * @return bool
     */
    public function isRipeForCheckout()
    {
        return !$this->attributes_are_empty(['home_address', 'county_id', 'town']);
    }

    /**
     * Checks if a specified user's attributes are empty
     *
     * @param array $attributes
     * @param int $err_count
     * @return bool
     */
    protected function attributes_are_empty(array $attributes, $err_count = 1)
    {

        static $count = 0;

        foreach ($attributes as $attribute) {

            if (empty($this->$attribute)) {

                $count++;
            }
        }

        return $count >= $err_count ? true : false;

    }

    /**
     * Check the user's age with an option of returning it
     * By default, we only return the fact that they passed/not
     *
     * @param $dateOfBirth
     * @param bool $returnAge
     *
     * @return bool|int
     */
    public function checkAge($dateOfBirth, $returnAge = false)
    {
        $from = new DateTime($dateOfBirth);
        $to = new DateTime('today');
        $years = $from->diff($to)->y;

        // check if user is over/under age
        $passed = $years > $this->minAge & $years < $this->maxAge ? true : false;

        $this->passedAgeTest = $passed;

        // return the age, or ..
        return $returnAge ? $years : $passed;

    }
}