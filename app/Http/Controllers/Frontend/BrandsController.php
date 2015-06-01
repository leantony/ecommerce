<?php namespace App\Http\Controllers\Frontend;

use app\Antony\DomainLogic\Modules\Brands\Base\BrandsEntity;
use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;
use Response;

class BrandsController extends Controller
{
    /**
     * The brands entity
     *
     * @var BrandsEntity
     */
    protected $brand;

    /**
     * @param BrandsEntity $brands
     */
    public function __construct(BrandsEntity $brands)
    {
        $this->brand = $brands;
    }

    /**
     * Display a listing of all brands
     *
     * @return Response
     */
    public function index()
    {
//        $brands = $this->brand->get();
//
//        return view('frontend.brands.index', compact('brands'));
        return redirect()->back();
    }


    /**
     * Display products within the brand
     *
     * @param Request $request
     * @param Brand $brand
     *
     * @return Response
     * @internal param int $id
     *
     */
    public function show(Request $request, Brand $brand)
    {

        $data = $this->brand->displayProductsWithBrands($brand, $request);

        return view('frontend.brands.products')
            ->with('brand', array_get($data, 'brand'))
            ->with('products', array_get($data, 'pages'));
    }

}
