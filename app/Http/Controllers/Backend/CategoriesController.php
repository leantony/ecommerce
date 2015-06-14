<?php namespace App\Http\Controllers\Backend;

use app\Antony\DomainLogic\Modules\Categories\CategoriesRepository;
use App\Http\Controllers\Controller;
use App\Http\Requests\Inventory\Categories\CategoryRequest;
use App\Http\Requests\Inventory\DeleteInventoryRequest;
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
            return link_to(route('backend.categories.edit', ['article' => $category->id]), 'Edit', ['data-target-model' => $category->id, 'class' => 'btn btn-xs btn-primary']);
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
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $category = $this->category->get($id);

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
        $category = $this->category->get($id);

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
