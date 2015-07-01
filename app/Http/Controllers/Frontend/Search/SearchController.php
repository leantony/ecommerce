<?php

namespace App\Http\Controllers\Frontend\Search;

use App\Antony\DomainLogic\Modules\Product\ProductSearch;
use App\Http\Controllers\Controller;
use App\Http\Requests\Search\SearchRequest;


class SearchController extends Controller
{

    /**
     * Product search module
     *
     * @var ProductSearch
     */
    protected $model;

    /**
     * @param ProductSearch $productSearch
     */
    public function __construct(ProductSearch $productSearch)
    {
        $this->model = $productSearch;
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function index()
    {
        return $this->featureUnavailable();
    }

    /**
     * @param SearchRequest $request
     *
     * @return $this|\Illuminate\View\View|mixed|\Symfony\Component\HttpFoundation\Response
     */
    public function show(SearchRequest $request)
    {
        if ($request->ajax()) {
            // turn on AJAX search in the search class
            $this->model->useAJAX = true;

            // disable pagination
            $this->model->paginate = false;

            // no need to set the request search param object, since it matches our requirements

            return $this->model->search($request)->processAJAXRequest();
        }

        return $this->model->search($request);

    }

}