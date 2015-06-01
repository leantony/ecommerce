<?php namespace app\Antony\DomainLogic\Modules\Product\Base;

use app\Antony\DomainLogic\Modules\DAL\Base\DataAccessLayer;
use app\Antony\DomainLogic\Modules\Product\ProductRepository;
use Carbon\Carbon;

class ProductEntity extends DataAccessLayer
{

    /**
     * Object name that will be displayed in the redirect msg
     *
     * @var string
     */
    protected $objectName = 'products';

    /**
     * @param ProductRepository $productRepository
     */
    public function __construct(ProductRepository $productRepository)
    {
        parent::__construct($productRepository);
    }

    /**
     * Displays a listing of all products
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|null
     */
    public function get()
    {
        return $this->repository->paginate(['category', 'subcategory', 'brand', 'reviews'], false, 12);
    }

    /**
     * Displays a sum of individual products in the database
     *
     * @return mixed
     */
    public function getInventoryCount()
    {
        return $this->repository->where('quantity', '<>', '0')->get()->fetch('quantity')->sum();
    }

    /**
     * Gets the sum of all products in the db. for instance, if a single product has a qt of 10, we shall get 10 instead of 1
     *
     * @return mixed
     */
    public function getAllProductsCount()
    {

        return $this->repository->all()->count();
    }

    /**
     * Displays all data about a single product
     *
     * @param $id
     *
     * @return mixed
     */
    public function displayProductData($id)
    {
        return $this->repository->getFirstBy('id', '=', $id, ['category', 'subcategory', 'reviews.user', 'brand']);
    }

    /**
     * Displays top rated products
     *
     * @return mixed
     */
    public function displayTopRated()
    {
        // we first fetch all products with reviews. Then get those that meet our criteria
        // our criteria states that a top rated product should have at least 4.0 stars and
        // be reviewed at least 2 times. The hard coded values are just defaults, just in-case
        // the ones in our config are missing

        // for now, that criteria will be ok, since we have a few products and users
        $data = $this->repository->with(['reviews'])->whereHas('reviews', function ($q) {

            $q->where('stars', '>=', config('site.reviews.hottest', 3.5));

        }, '>=', config('site.reviews.count', 10))->get()->sortByDesc(function ($p) {

            // sort by the number of stars
            return $p->reviews->sortBy(function ($r) {
                return $r->stars;
            });
        });

        return $data;
    }

    /**
     * Display new products on the home page
     *
     * @return mixed
     */
    public function displayNewProducts()
    {
        $time = Carbon::now()->subDays(config('site.products.new.age', 14));

        $data = $this->repository->with(['reviews', 'brand'])->where('created_at', '>=', $time)->take(15)->get();

        return $data->sortByDesc(function ($p) {
            return $p->created_at;
        });
    }
}