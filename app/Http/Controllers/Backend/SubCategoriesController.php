<?php namespace App\Http\Controllers\Backend;

use app\Antony\DomainLogic\Modules\SubCategories\SubcategoriesRepository;
use App\Http\Controllers\Controller;
use App\Http\Requests\Inventory\DeleteInventoryRequest;
use App\Http\Requests\Inventory\SubCategories\SubCategoryRequest;
use Response;

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
        $subcategories = $this->subcategory->displayAllSubCategories();

        return view('backend.subCategories.index', compact('subcategories'));
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
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $subcategory = $this->subcategory->get($id);

        return view('backend.subCategories.edit', compact('subcategory'));
    }

    /**
     * Show the form for editing the specified SubCategory.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $subcategory = $this->subcategory->get($id);

        return view('backend.subCategories.edit', compact('subcategory'));
    }

    /**
     * Update the specified subCategory in storage.
     *
     * @param SubCategoryRequest $request
     * @param  int $id
     *
     * @return Response
     */
    public function update(SubCategoryRequest $request, $id)
    {
        $this->data = $this->subcategory->edit($id, $request->all());

        return $this->handleRedirect($request);
    }

    /**
     * Remove the specified subCategory from storage.
     *
     * @param DeleteInventoryRequest $request
     * @param  int $id
     *
     * @return Response
     */
    public function destroy(DeleteInventoryRequest $request, $id)
    {
        $this->data = $this->subcategory->delete($id);

        return $this->handleRedirect($request, route('backend.subcategories.index'));
    }

}
