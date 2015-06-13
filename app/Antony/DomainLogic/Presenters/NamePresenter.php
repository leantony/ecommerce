<?php namespace app\Antony\DomainLogic\Presenters;

use Laracasts\Presenter\Presenter;

class NamePresenter extends Presenter
{

    /**
     * @return string
     */
    public function name()
    {

        return beautify($this->name);
    }
}