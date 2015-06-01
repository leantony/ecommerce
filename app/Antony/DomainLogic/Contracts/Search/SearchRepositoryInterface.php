<?php namespace app\Antony\DomainLogic\Contracts\Search;

use Illuminate\Http\Request;

interface SearchRepositoryInterface
{

    /**
     * Finds an item by keywords
     *
     * @param Request $request
     *
     * @return mixed
     */
    public function search(Request $request);

    /**
     * Process the search result
     *
     * @param $result
     *
     * @return mixed
     */
    public function processResult($result);
}