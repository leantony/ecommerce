<?php namespace App\Http\Controllers\Backend;

use app\Antony\DomainLogic\Modules\Brands\BrandsRepository;
use App\Http\Controllers\Controller;
use App\Http\Requests\Inventory\Brands\BrandFormRequest;
use App\Http\Requests\Inventory\DeleteInventoryRequest;
use Response;
use yajra\Datatables\Datatables;

class BrandsController extends Controller
{
    /**
     * The brands module
     *
     * @var BrandsRepository
     */
    protected $brand;

    /**
     * @param BrandsRepository $brands
     */
    public function __construct(BrandsRepository $brands)
    {
        $this->brand = $brands;
    }

    /**
     * Display a listing of brands
     *
     * @return Response
     */
    public function index()
    {
        return view('backend.brands.index');
    }

    /**
     * @return mixed
     */
    public function getDataTable()
    {

        $brands = $this->brand->with(['products'])->select('*');

        $data = Datatables::of($brands)->addColumn('edit', function ($brand) {
            return link_to(route('backend.brands.edit', ['id' => $brand->id]), 'Edit', ['data-target-model' => $brand->id, 'class' => 'btn btn-xs btn-primary']);
        })->addColumn('count', function($brand){

            return $brand->products()->count();
        });

        return $data->make(true);
    }

    /**
     * Show the form for creating a new product brand
     *
     * @return Response
     */
    public function create()
    {
        return view('backend.brands.create');
    }

    /**
     * Store a newly created product brand in storage.
     *
     * @param BrandFormRequest $request
     *
     * @return Response
     */
    public function store(BrandFormRequest $request)
    {
        $this->data = $this->brand->add($request->all());

        return $this->handleRedirect($request, route('backend.brands.index'));
    }

    /**
     * Display the specified product brand.
     *
     * @param  int $id
     *
     * @return Response
     *
     */
    public function show($id)
    {
        $brand = $this->brand->find($id);

        return view('backend.brands.edit', compact('brand'));
    }

    /**
     * Show the form for editing the specified product brand.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $brand = $this->brand->find($id);

        return view('backend.brands.edit', compact('brand'));
    }

    /**
     * Update the specified product brand in storage.
     *
     * @param BrandFormRequest $request
     * @param  int $id
     *
     * @return Response
     */
    public function update(BrandFormRequest $request, $id)
    {
        $this->data = $this->brand->edit($id, $request->except('_token'));

        return $this->handleRedirect($request);
    }

    /**
     * Remove the specified product brand from storage.
     *
     * @param DeleteInventoryRequest $request
     * @param  int $id
     *
     * @return Response
     */
    public function destroy(DeleteInventoryRequest $request, $id)
    {
        $this->data = $this->brand->delete($id);

        return $this->handleRedirect($request, route('backend.brands.index'));
    }

}
