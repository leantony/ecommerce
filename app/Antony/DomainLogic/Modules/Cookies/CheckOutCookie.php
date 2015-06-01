<?php namespace app\Antony\DomainLogic\Modules\Cookies;

use app\Antony\DomainLogic\Modules\Cookies\Base\AppCookie;

class CheckOutCookie extends AppCookie
{

    public $name = 'checkout';

    public $timespan = 300;
}