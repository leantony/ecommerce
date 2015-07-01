<?php

namespace App\Http\Controllers\Backend\Inventory;

use app\Antony\DomainLogic\Modules\Categories\CategoriesRepository;
use App\Http\Controllers\Controller;
use App\Http\Requests\Inventory\Categories\CategoryRequest;
use App\Http\Requests\Inventory\DeleteInventoryRequest;
use App\Models\Category;
use Response;
use yajra\Datatables\Datatables;

class CategoriesController extends Controller
{
    /**
     * The categories module
     *
     * @var CategoriesRepository
     */
    protected $category;

    /**
     * @param CategoriesRepository $categoriesRepository
     */
    public function __construct(CategoriesRepository $categoriesRepository)
    {
        $this->category = $categoriesRepository;
    }

    /**
     * Display a listing of categories
     *
     * @return Response
     */
    public function index()
    {
        return view('backend.categories.index');
    }

    /**
     * @return mixed
     */
    public function getDataTable()
    {

        $categories = $this->category->select(['id', 'name', 'created_at', 'updated_at']);

        return Datatables::of($categories)->addColumn('edit', function ($category) {
            return link_to(route('backend.categories.edit', ['category' => $category->id]), 'Edit', ['data-target-model' => $category->id, 'class' => 'btn btn-xs btn-primary']);
        })->make(true);
    }

    /**
     * Show the form for creating a new Category
     *
     * @return Response
     */
    public function create()
    {
        return view('backend.categories.create');
    }

    /**
     * Store a newly created Category in storage.
     *
     * @param CategoryRequest $request
     *
     * @return Response
     */
    public function store(CategoryRequest $request)
    {
        $this->data = $this->category->add($request->all());

        return $this->handleRedirect($request, route('backend.categories.index'));

    }

    /**
     * Display the specified Category.
     *
     * @param Category $category
     * @return Response
     */
    public function show(Category $category)
    {
        return view('backend.categories.edit', compact('category'));
    }

    /**
     * Show the form for editing the specified Category.
     *
     * @param Category $category
     * @return Response
     */
    public function edit(Category $category)
    {
        return view('backend.categories.edit', compact('category'));
    }

    /**
     * Update the specified Category in storage.
     *
     * @param CategoryRequest $request
     *
     * @param Category $category
     * @return Response
     */
    public function update(CategoryRequest $request, Category $category)
    {
        $this->data = $category->update($request->all());

        return $this->handleRedirect($request);
    }

    /**
     * Remove the specified Category from storage.
     *
     * @param DeleteInventoryRequest $request
     *
     * @param Category $category
     * @return Response
     * @throws \Exception
     */
    public function destroy(DeleteInventoryRequest $request, Category $category)
    {
        $this->data = $category->delete();

        return $this->handleRedirect($request, route('backend.categories.index'));
    }

}
