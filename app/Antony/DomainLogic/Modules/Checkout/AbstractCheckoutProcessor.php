<?php namespace app\Antony\DomainLogic\Modules\Checkout;

use app\Antony\DomainLogic\Contracts\Checkout\CheckoutContract;
use app\Antony\DomainLogic\Modules\Cookies\CheckOutCookie;
use app\Antony\DomainLogic\Modules\Guests\GuestRepository;
use app\Antony\DomainLogic\Modules\User\UserRepository;
use App\Models\Guest;

abstract class AbstractCheckoutProcessor implements CheckoutContract
{
    use CheckoutRedirector;

    /**
     * Route to previous step
     *
     * @var null
     */
    protected $previousRoute = null;

    /**
     * Route to next step
     *
     * @var string
     */
    protected $nextStepRoute = null;

    /**
     * Default route
     *
     * @var string
     */
    protected $defaultRoute = 'checkout.auth';

    /**
     * Specifies if the user should be redirected back once they complete an action
     *
     * @var boolean
     */
    protected $redirectBack = false;

    /**
     * @var string
     */
    protected $stepStatus;

    /**
     * @var array
     */
    protected $cookieData;

    /**
     * @var Guest
     */
    protected $guest;

    /**
     * @var GuestRepository
     */
    protected $guestRepository;

    /**
     * @var CheckOutCookie
     */
    protected $checkOutCookie;

    /**
     * @var UserRepository
     */
    protected $userRepository;

    /**
     * @param GuestRepository $guestRepository
     * @param CheckOutCookie $checkOutCookie
     * @param UserRepository $userRepository
     *
     * @internal param Authenticatable $authenticatable
     */
    public function __construct(GuestRepository $guestRepository, CheckOutCookie $checkOutCookie, UserRepository $userRepository)
    {

        $this->guestRepository = $guestRepository;
        $this->checkOutCookie = $checkOutCookie;
        $this->userRepository = $userRepository;
    }

    /**
     * Creates and queues the checkout cookie
     *
     * @param $step_id
     * @param $data
     *
     * @return mixed|void
     */
    public function createCheckoutCookie($step_id, $data)
    {
        $cookie_data = [
            'step' => $step_id,
            'state' => $this->getStepStatus(),
            'data' => $data
        ];
        // make the cookie that will determine the user's state in the checkout progress
        $this->checkOutCookie->cookie->queue($this->checkOutCookie->name, $cookie_data, $this->checkOutCookie->timespan);
    }

    /**
     * @return mixed
     */
    public function getStepStatus()
    {
        return $this->stepStatus;
    }


    /**
     * Gets the data from a cookie
     *
     * @return mixed
     */

    /**
     * @param mixed $stepStatus
     */
    public function setStepStatus($stepStatus)
    {
        $this->stepStatus = $stepStatus;
    }

    /**
     * @param $step_id
     * @param $new_data
     */
    public function updateCheckoutCookie($step_id, $new_data)
    {
        $this->checkOutCookie->destroy();

        $this->createCheckoutCookie($step_id, $new_data);
    }

    /**
     * Gets details about the guest usr
     *
     * @return array|null
     */
    public function getGuestDetails()
    {
        return $this->isAGuest() ? $this->cookieData : null;
    }

    /**
     * Check if the user is a Guest
     *
     * @return bool
     */
    public function isAGuest()
    {
        $guest = $this->getCookieData();

        return $guest instanceof Guest;
    }

    /**
     * @param string $key
     *
     * @return mixed
     */
    public function getCookieData($key = 'data')
    {
        $this->cookieData = array_get($this->checkOutCookie->fetch()->get(), $key);

        return $this->cookieData;
    }

    /**
     * @return \Illuminate\Contracts\Auth\Guard
     */
    public function retrieveUserDetails()
    {
        return auth()->user();
    }

    /**
     * @return string
     */
    public function retrieveStepData()
    {
        return json_encode($this->getCookieData());
    }

}