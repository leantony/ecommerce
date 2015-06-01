<?php namespace App\Http\Controllers\Backend;

use app\Antony\DomainLogic\Modules\Categories\Base\CategoryEntity;
use App\Http\Controllers\Controller;
use App\Http\Requests\Inventory\Categories\CategoryRequest;
use App\Http\Requests\Inventory\DeleteInventoryRequest;
use Response;

class CategoriesController extends Controller
{
    /**
     * The categories module
     *
     * @var CategoryEntity
     */
    protected $category;

    /**
     * @param CategoryEntity $categoriesRepository
     */
    public function __construct(CategoryEntity $categoriesRepository)
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
        $categories = $this->category->get();

        return view('backend.categories.index', compact('categories'));
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
        $this->data = $this->category->create($request->all());

        return $this->handleRedirect($request, route('backend.categories.index'));

    }

    /**
     * Display the specified Category.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $category = $this->category->retrieve($id);

        return view('backend.categories.edit', compact('category'));
    }

    /**
     * Show the form for editing the specified Category.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $category = $this->category->retrieve($id);

        return view('backend.categories.edit', compact('category'));
    }

    /**
     * Update the specified Category in storage.
     *
     * @param CategoryRequest $request
     * @param  int $id
     *
     * @return Response
     */
    public function update(CategoryRequest $request, $id)
    {
        $this->data = $this->category->edit($id, $request->all());

        return $this->handleRedirect($request);
    }

    /**
     * Remove the specified Category from storage.
     *
     * @param DeleteInventoryRequest $request
     * @param  int $id
     *
     * @return Response
     */
    public function destroy(DeleteInventoryRequest $request, $id)
    {
        $this->data = $this->category->delete($id);

        return $this->handleRedirect($request, route('backend.categories.index'));
    }

}
