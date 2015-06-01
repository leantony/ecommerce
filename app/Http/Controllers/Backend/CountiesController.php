<?php namespace App\Http\Controllers\Backend;

use app\Antony\DomainLogic\Modules\Counties\Base\CountyEntity;
use App\Http\Controllers\Controller;
use App\Http\Requests\Counties\CountyRequest;
use App\Http\Requests\Counties\DeleteCountyRequest;
use Response;

class CountiesController extends Controller
{
    /**
     * The counties module
     *
     * @var CountyEntity
     */
    protected $county;

    /**
     * @param CountyEntity $repository
     */
    public function __construct(CountyEntity $repository)
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
        $counties = $this->county->get();

        return view('backend.counties.index', compact('counties'));
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
        $this->data = $this->county->create($request->all());

        return $this->handleRedirect($request, route('backend.counties.index'));
    }

    /**
     * Display the specified county.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $county = $this->county->retrieve($id);

        return view('backend.counties.edit', compact('county'));
    }

    /**
     * Show the form for editing the specified county.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $county = $this->county->retrieve($id);

        return view('backend.counties.edit', compact('county'));
    }

    /**
     * Update the specified county in storage.
     *
     * @param CountyRequest $request
     * @param  int $id
     *
     * @return Response
     */
    public function update(CountyRequest $request, $id)
    {
        $this->data = $this->county->edit($id, $request->all());

        return $this->handleRedirect($request);
    }

    /**
     * Remove the specified county from storage.
     *
     * @param DeleteCountyRequest $request
     * @param  int $id
     *
     * @return Response
     * @internal param $DeleteCountyRequest
     */
    public function destroy(DeleteCountyRequest $request, $id)
    {
        $this->data = $this->county->delete($id);

        return $this->handleRedirect($request, route('backend.counties.index'));
    }

}
