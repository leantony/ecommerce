<?php namespace app\Antony\DomainLogic\Presenters;

use DateTime;
use Laracasts\Presenter\Presenter;

class UserPresenter extends Presenter
{

    /**
     * @return string
     */
    public function fullName()
    {
        return beautify($this->first_name . ' ' . $this->last_name);
    }

    /**
     * @return string
     */
    public function firstName()
    {

        return beautify($this->first_name);
    }

    /**
     * @return int
     */
    public function age()
    {

        $from = new DateTime($this->dob);
        $to = new DateTime('today');
        $years = $from->diff($to)->y;

        // check that the age is not greater than a normal humans age
        return $years < 120 ? $years : 0;
    }

    /**
     * @return mixed
     */
    public function accountAge()
    {
        return $this->created_at->diffForHumans();
    }

    /**
     * @return mixed
     */
    public function lastUpdateDate()
    {
        return $this->updated_at->diffForHumans();
    }

    /**
     * @return mixed
     */
    public function lastLogin()
    {
        return is_null($this->last_login) ? "unknown" : $this->last_login->diffForHumans();
    }
}