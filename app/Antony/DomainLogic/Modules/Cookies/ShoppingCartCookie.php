<?php namespace app\Antony\DomainLogic\Modules\Cookies;

use app\Antony\DomainLogic\Modules\Cookies\Base\AppCookie;

class ShoppingCartCookie extends AppCookie
{

    public $name = 'shopping_cart';

    public $timespan = 3600;
}