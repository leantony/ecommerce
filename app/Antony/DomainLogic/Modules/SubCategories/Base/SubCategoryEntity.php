<?php namespace app\Antony\DomainLogic\Modules\SubCategories\Base;

use app\Antony\DomainLogic\Modules\DAL\Base\DataAccessLayer;
use app\Antony\DomainLogic\Modules\SubCategories\SubcategoriesRepository;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class SubCategoryEntity extends DataAccessLayer
{

    protected $objectName = 'subcategories';

    /**
     * @param SubcategoriesRepository $subcategoriesRepository
     */
    public function __construct(SubcategoriesRepository $subcategoriesRepository)
    {
        parent::__construct($subcategoriesRepository);
    }

    /**
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|null
     */
    public function get()
    {
        return $this->repository->paginate(['category']);
    }

    /**
     * @param $id
     *
     * @return mixed
     */
    public function retrieve($id)
    {
        return $this->repository->find($id, ['category']);
    }

    /**
     * Display products related to another product
     *
     * @param $subcategory_id
     *
     * @param Request $request
     *
     * @return mixed
     */
    public function includeRelatedProducts($subcategory_id, Request $request = null)
    {
        if ($subcategory_id instanceof SubCategory) {
            $data = $subcategory_id->with('products.reviews')->whereId($subcategory_id->id)->get();
        } else {
            $data = $this->repository->with(['products.reviews'])->whereId($subcategory_id)->get();
        }

        $collection = new Collection();

        $sub = '';

        foreach ($data as $subcategory) {

            $sub = $subcategory;
            foreach ($subcategory->products as $product) {

                $collection->push($product);
            }

        }

        $pages = $this->paginateCollection($collection, 5, $request);

        return compact('pages', 'sub');
    }

    /**
     * Display featured laptops
     *
     * @return mixed
     */
    public function displayFeaturedLaptops()
    {

        $data = $this->repository->with(['products.reviews', 'products.brand'])->where('name', 'like', 'laptop%')->orWhere('name', 'like', 'ultrabook%')->take(20)->get();

        // sort the products by their total price => price + tax + discount
        return $this->createCustomProductCollection($data)->sortBy(function ($p) {
            return $p->total()->getAmount();
        }, SORT_ASC);
    }

    /**
     * Creates a custom data collection of products
     *
     * @param $data
     *
     * @return Collection
     */
    public function createCustomProductCollection($data)
    {
        $collection = new Collection();

        foreach ($data as $subcategory) {

            foreach ($subcategory->products as $product) {

                $collection->push($product);
            }

        }

        // we just sort them alphabetically
        return $collection->sortBy(function ($p) {
            return $p->name;
        });
    }

    /**
     * Display featured tablets
     *
     * @return mixed
     */
    public function displayFeaturedTablets()
    {
        $data = $this->repository->with(['products.reviews', 'products.brand'])->where('name', 'like', 'tablets%')->orWhere('name', 'like', 'apple%')->take(20)->get();

        return $this->createCustomProductCollection($data);
    }

    /**
     * Display featured phones
     *
     * @param $phone
     *
     * @return SubCategoryEntity
     */
    public function displayFeaturedMobilePhones($phone)
    {
        $data = $this->repository->with(['products.reviews', 'products.brand'])->where('name', 'like', 'gala%')->take(20)->get();

        return $this->createCustomProductCollection($data);
    }
}