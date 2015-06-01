<?php namespace App\Http\Controllers\Frontend;

use app\Antony\DomainLogic\Modules\Product\Base\ProductEntity;
use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Response;

class ProductsController extends Controller
{

    protected $product;

    /**
     * @param ProductEntity $productRepository
     */
    public function __construct(ProductEntity $productRepository)
    {
        $this->product = $productRepository;
    }

    /**
     * Display a listing of products
     *
     * @return Response
     */
    public function index()
    {
        $products = $this->product->get();

        return view('frontend.products.index', compact('products'));
    }

    /**
     * Display the specified product.
     *
     * @param Product $p
     *
     * @return Response
     *
     */
    public function show(Product $p)
    {
        $product = $p->with('category', 'subcategory', 'brand', 'reviews.user')->whereId($p->id)->first();

        return view('frontend.products.single', compact('product'));
    }
}
