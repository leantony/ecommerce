<?php namespace app\Antony\DomainLogic\Modules\Cookies;

use app\Antony\DomainLogic\Modules\Cookies\Base\AppCookie;

class OrderCookie extends AppCookie
{

    public $name = 'client_order';

    public $timespan = 300;
}