<?php namespace App\Http\Controllers\Backend;

use app\Antony\DomainLogic\Modules\Product\Base\ProductEntity;
use App\Http\Controllers\Controller;
use App\Http\Requests\Inventory\DeleteInventoryRequest;
use App\Http\Requests\Inventory\Products\ProductRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ProductsController extends Controller
{
    /**
     * The products module
     *
     * @var ProductEntity
     */
    protected $product;

    /**
     * @param ProductEntity $repository
     */
    public function __construct(ProductEntity $repository)
    {
        $this->product = $repository;
    }

    /**
     * Display a listing of products
     *
     * @return Response
     */
    public function index()
    {
        $inventoryCount = $this->product->getInventoryCount();

        $productsCount = $this->product->getAllProductsCount();

        $products = $this->product->get();

        return view('backend.products.index', compact('products', 'inventoryCount', 'productsCount'));
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
        $this->data = $this->product->create($request->all());

        return $this->handleRedirect($request, route('backend.products.index'));
    }

    /**
     * Display the specified product.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $product = $this->product->retrieve($id);

        return view('backend.products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified product.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $product = $this->product->retrieve($id);

        return view('backend.products.edit', compact('product'));
    }

    /**
     * Update the specified product in storage.
     *
     * @param ProductRequest $request
     * @param  int $id
     *
     * @return Response
     */
    public function update(ProductRequest $request, $id)
    {
        $this->data = $this->product->edit($id, $request->all());

        return $this->handleRedirect($request);
    }

    /**
     * Remove the specified product from storage.
     *
     * @param DeleteInventoryRequest|Request $request
     * @param  int $id
     *
     * @return Response
     */
    public function destroy(DeleteInventoryRequest $request, $id)
    {
        $this->data = $this->product->delete($id);

        return $this->handleRedirect($request, route('backend.products.index'));
    }

}
