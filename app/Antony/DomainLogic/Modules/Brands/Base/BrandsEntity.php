<?php namespace app\Antony\DomainLogic\Modules\Brands\Base;

use app\Antony\DomainLogic\Modules\Brands\BrandsRepository;
use app\Antony\DomainLogic\Modules\DAL\Base\DataAccessLayer;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class BrandsEntity extends DataAccessLayer
{

    /**
     * Object name that will be displayed in the redirect msg
     *
     * @var string
     */
    protected $objectName = 'brands';

    /**
     * @param BrandsRepository $brandsRepository
     */
    public function __construct(BrandsRepository $brandsRepository)
    {
        parent::__construct($brandsRepository);
    }

    /**
     * Displays a listing of all brands
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|null
     */
    public function get()
    {
        return $this->repository->paginate(['products']);
    }

    /**
     * Displays related products within a brand
     *
     * @param $brand_id
     *
     * @param Request $request
     *
     * @return mixed
     */
    public function displayProductsWithBrands($brand_id, Request $request)
    {
        if ($brand_id instanceof Brand) {
            $data = $brand_id->with('products.category', 'products.reviews', 'products.subcategory')->whereId($brand_id->id)->get();
        } else {
            $data = $this->repository->with(['products.category', 'products.reviews', 'products.subcategory'])->where('id', $brand_id)->get();
        }

        $collection = new Collection();

        $brand = '';

        // customize our collection to only include products. Other variables can be compacted later
        foreach ($data as $manufacturer) {

            $brand = $manufacturer;
            foreach ($manufacturer->products as $product) {

                $collection->push($product);
            }

        }

        $pages = $this->paginateCollection($collection, 10, $request);

        return compact('pages', 'brand');
    }

    /**
     * Displays a listing of brands on the homepage
     *
     * @return mixed
     */
    public function displayBrandsOnHomePage()
    {
        $data = $this->repository->where('logo', '<>', 'null')->sortBy('name');

        return $data;
    }
}