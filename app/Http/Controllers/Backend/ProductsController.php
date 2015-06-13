<?php namespace App\Http\Controllers\Backend;

use app\Antony\DomainLogic\Modules\Product\ProductRepository;
use App\Http\Controllers\Controller;
use App\Http\Requests\Inventory\DeleteInventoryRequest;
use App\Http\Requests\Inventory\Products\ProductRequest;
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

        return Datatables::of($products)->addColumn('edit', function ($article) {
            return link_to(route('backend.products.edit', ['id' => $article->id]), 'Edit', ['data-target-model' => $article->id, 'class' => 'btn btn-xs btn-primary']);
        })->editColumn('price', '{{format_money($price)}}')->make(true);
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
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $product = $this->products->get($id);

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
        $product = $this->products->get($id);

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
        $this->data = $this->products->edit($id, $request->all());

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
        $this->data = $this->products->delete($id);

        return $this->handleRedirect($request, route('backend.products.index'));
    }

}
