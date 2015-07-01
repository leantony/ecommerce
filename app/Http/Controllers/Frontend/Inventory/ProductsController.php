<?php

namespace App\Http\Controllers\Frontend\Inventory;

use app\Antony\DomainLogic\Modules\Product\ProductRepository;
use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Response;

class ProductsController extends Controller
{

    protected $products;

    /**
     * @param ProductRepository $productRepository
     */
    public function __construct(ProductRepository $productRepository)
    {
        $this->products = $productRepository;
    }

    /**
     * Display a listing of products
     *
     * @return Response
     */
    public function index()
    {
        $products = $this->products->displayAllProducts();

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
