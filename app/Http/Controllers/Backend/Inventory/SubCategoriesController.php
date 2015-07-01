<?php

namespace App\Http\Controllers\Backend\Inventory;

use app\Antony\DomainLogic\Modules\SubCategories\SubcategoriesRepository;
use App\Http\Controllers\Controller;
use App\Http\Requests\Inventory\DeleteInventoryRequest;
use App\Http\Requests\Inventory\SubCategories\SubCategoryRequest;
use App\Models\SubCategory;
use Response;
use yajra\Datatables\Datatables;

class SubCategoriesController extends Controller
{
    /**
     * The subcategories entity
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
     * Display a listing of sub categories
     *
     * @return Response
     */
    public function index()
    {
        return view('backend.subCategories.index');
    }

    /**
     * @return mixed
     */
    public function getDataTable()
    {

        $categories = $this->subcategory->with(['category'])->select('*');

        $data = Datatables::of($categories)->addColumn('edit', function ($subcat) {
            return link_to(route('backend.subcategories.edit', ['subcategory' => $subcat->id]), 'Edit', ['data-target-model' => $subcat->id, 'class' => 'btn btn-xs btn-primary']);
        });

        return $data->make(true);
    }

    /**
     * Show the form for creating a new subCategory
     *
     * @return Response
     */
    public function create()
    {
        return view('backend.subCategories.create');
    }

    /**
     * Store a newly created subCategory in storage.
     *
     * @param SubCategoryRequest $request
     *
     * @return Response
     */
    public function store(SubCategoryRequest $request)
    {
        $this->data = $this->subcategory->add($request->all());

        return $this->handleRedirect($request, route('backend.subcategories.index'));
    }

    /**
     * Display the specified SubCategory.
     *
     * @param SubCategory $subcategory
     * @return Response
     */
    public function show(SubCategory $subcategory)
    {
        return view('backend.subCategories.edit', compact('subcategory'));
    }

    /**
     * Show the form for editing the specified SubCategory.
     *
     * @param SubCategory $subcategory
     * @return Response
     */
    public function edit(SubCategory $subcategory)
    {
        return view('backend.subCategories.edit', compact('subcategory'));
    }

    /**
     * Update the specified subCategory in storage.
     *
     * @param SubCategoryRequest $request
     *
     * @return Response
     */
    public function update(SubCategoryRequest $request, SubCategory $subCategory)
    {
        $this->data = $subCategory->update($request->all());

        return $this->handleRedirect($request);
    }

    /**
     * Remove the specified subCategory from storage.
     *
     * @param DeleteInventoryRequest $request
     *
     * @param SubCategory $subCategory
     * @return Response
     * @throws \Exception
     */
    public function destroy(DeleteInventoryRequest $request, SubCategory $subCategory)
    {
        $this->data = $subCategory->delete();

        return $this->handleRedirect($request, route('backend.subcategories.index'));
    }

}
