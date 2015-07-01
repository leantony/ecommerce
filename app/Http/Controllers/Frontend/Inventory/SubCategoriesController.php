<?php

namespace App\Http\Controllers\Frontend\Inventory;

use app\Antony\DomainLogic\Modules\SubCategories\SubcategoriesRepository;
use App\Http\Controllers\Controller;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Response;

class SubCategoriesController extends Controller
{
    /**
     * The subcategories repository
     *
     * @var SubCategoriesRepository
     */
    protected $subcategory;

    /**
     * @param SubCategoriesRepository $repository
     */
    public function __construct(SubcategoriesRepository $repository)
    {
        $this->subcategory = $repository;
    }

    /**
     * Display a listing of the resource.
     * GET /subcategories
     *
     * @return Response
     */
    public function index()
    {
        //
    }

    /**
     * Display the specified resource.
     * GET /subcategories/{id}
     *
     * @param Request $request
     *
     * @param SubCategory $subCategory
     * @return Response
     */
    public function show(Request $request, SubCategory $subCategory)
    {
        $data = $this->subcategory->includeRelatedProducts($subCategory, $request);

        return view('frontend.subcategories.products', $data)
            ->with('subcategory', array_get($data, 'sub'))
            ->with('products', array_get($data, 'pages'));
    }
}