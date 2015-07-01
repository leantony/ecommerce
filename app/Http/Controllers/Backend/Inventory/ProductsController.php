<?php

namespace App\Http\Controllers\Backend\Inventory;

use app\Antony\DomainLogic\Modules\Product\ProductRepository;
use App\Http\Controllers\Controller;
use App\Http\Requests\Inventory\DeleteInventoryRequest;
use App\Http\Requests\Inventory\Products\ProductRequest;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use yajra\Datatables\Datatables;

class ProductsController extends Controller
{
    /**
     * The products module
     *
     * @var ProductRepository
     */
    protected $products;

    /**
     * @param ProductRepository $repository
     */
    public function __construct(ProductRepository $repository)
    {
        $this->products = $repository;
    }

    /**
     * Display a listing of products
     *
     * @return Response
     */
    public function index()
    {
        $inventoryCount = $this->products->getInventoryCount();

        $productsCount = $this->products->getAllProductsCount();

        return view('backend.products.index', compact('inventoryCount', 'productsCount'));
    }

    /**
     * @return mixed
     */
    public function getDataTable()
    {

        $products = $this->products->with(['category', 'subcategory', 'brand', 'reviews'])->select('*');

        return Datatables::of($products)->addColumn('edit', function ($product) {
            return link_to(route('backend.products.edit', ['id' => $product->id]), 'Edit', ['data-target-model' => $product->id, 'class' => 'btn btn-xs btn-primary']);
        })->editColumn('price', function ($product) {
            return format_money($product->price);
        })->make(true);
    }

    /**
     * Show the form for creating a new product
     *
     * @return Response
     */
    public function create()
    {
        return view('backend.products.create');
    }

    /**
     * Store a newly created product in storage.
     *
     * @param ProductRequest $request
     *
     * @return Response
     */
    public function store(ProductRequest $request)
    {
        $this->data = $this->products->add($request->all());

        return $this->handleRedirect($request, route('backend.products.index'));
    }

    /**
     * Display the specified product.
     *
     * @param Product $product
     * @return Response
     */
    public function show(Product $product)
    {
        return view('backend.products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified product.
     *
     * @param Product $product
     * @return Response
     */
    public function edit(Product $product)
    {
        return view('backend.products.edit', compact('product'));
    }

    /**
     * Update the specified product in storage.
     *
     * @param ProductRequest $request
     * @param Product $product
     * @return Response
     *
     */
    public function update(ProductRequest $request, Product $product)
    {
        $this->data = $product->update($request->all());

        return $this->handleRedirect($request);
    }

    /**
     * Remove the specified product from storage.
     *
     * @param DeleteInventoryRequest|Request $request
     *
     * @param Product $product
     * @return Response
     * @throws \Exception
     */
    public function destroy(DeleteInventoryRequest $request, Product $product)
    {
        $this->data = $product->delete();

        return $this->handleRedirect($request, route('backend.products.index'));
    }

}
