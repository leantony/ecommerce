<?php namespace app\Antony\DomainLogic\Contracts\Database;

interface DataAccessInterface
{

    public function getAllItems();

    public function getDataResult($json = false);
}