<?php namespace app\Antony\DomainLogic\Modules\DAL;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;

trait EloquentExtensions
{

    /**
     * Paginates a collection. For simple pagination, one can override this function
     *
     * a little help from http://laravelsnippets.com/snippets/custom-data-pagination
     *
     * @param Collection $data
     * @param int $perPage
     * @param Request $request
     * @param null $page
     *
     * @return LengthAwarePaginator
     */
    public function paginateCollection(Collection $data, $perPage, Request $request, $page = null)
    {
        $pg = $request->get('page');

        $page = $page ? (int)$page * 1 : (isset($pg) ? (int)$request->get('page') * 1 : 1);
        $offset = ($page * $perPage) - $perPage;

        return new LengthAwarePaginator($data->splice($offset, $perPage), $data->count(), $perPage, Paginator::resolveCurrentPage(), ['path' => Paginator::resolveCurrentPath(),]);
    }
}