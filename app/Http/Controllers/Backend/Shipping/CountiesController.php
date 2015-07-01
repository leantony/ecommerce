<?php

namespace App\Http\Controllers\Backend\Shipping;

use app\Antony\DomainLogic\Modules\Counties\CountiesRepository;
use App\Http\Controllers\Controller;
use App\Http\Requests\Counties\CountyRequest;
use App\Http\Requests\Counties\DeleteCountyRequest;
use App\Models\County;
use Response;
use yajra\Datatables\Datatables;

class CountiesController extends Controller
{
    /**
     * The counties module
     *
     * @var CountiesRepository
     */
    protected $county;

    /**
     * @param CountiesRepository $repository
     */
    public function __construct(CountiesRepository $repository)
    {
        $this->county = $repository;
    }

    /**
     * Display a listing of categories
     *
     * @return Response
     */
    public function index()
    {
        return view('backend.counties.index');
    }

    /**
     * @return mixed
     */
    public function getDataTable()
    {

        $counties = $this->county->select(['id', 'name', 'alias', 'created_at', 'updated_at']);

        $data = Datatables::of($counties)->addColumn('edit', function ($county) {
            return link_to(route('backend.counties.edit', ['county' => $county->id]), 'Edit', ['data-target-model' => $county->id, 'class' => 'btn btn-xs btn-primary']);
        });

        return $data->make(true);
    }

    /**
     * Show the form for creating a new county
     *
     * @return Response
     */
    public function create()
    {
        return view('backend.counties.create');
    }

    /**
     * Store a newly created county in storage.
     *
     * @param CountyRequest $request
     *
     * @return Response
     */
    public function store(CountyRequest $request)
    {
        $this->data = $this->county->add($request->all());

        return $this->handleRedirect($request, route('backend.counties.index'));
    }

    /**
     * Display the specified county.
     *
     * @param County $county
     * @return Response
     */
    public function show(County $county)
    {
        return view('backend.counties.edit', compact('county'));
    }

    /**
     * Show the form for editing the specified county.
     *
     * @param County $county
     * @return Response
     *
     */
    public function edit(County $county)
    {
        return view('backend.counties.edit', compact('county'));
    }

    /**
     * Update the specified county in storage.
     *
     * @param CountyRequest $request
     *
     * @param County $county
     * @return Response
     */
    public function update(CountyRequest $request, County $county)
    {
        $this->data = $county->update($request->all());

        return $this->handleRedirect($request);
    }

    /**
     * Remove the specified county from storage.
     *
     * @param DeleteCountyRequest $request
     *
     * @param County $county
     * @return Response
     * @throws \Exception
     */
    public function destroy(DeleteCountyRequest $request, County $county)
    {
        $this->data = $county->delete();

        return $this->handleRedirect($request, route('backend.counties.index'));
    }

}
