<?php namespace app\Antony\DomainLogic\Modules\Product;

use app\Antony\DomainLogic\Modules\DAL\EloquentRepository;
use App\Models\Product;
use Carbon\Carbon;

class ProductRepository extends EloquentRepository
{
    /**
     * The product sku
     *
     * @var string
     */
    protected $skuString = 'PCW';

    /**
     * Add a product to stock
     *
     * @param $data
     *
     * @return static
     */
    public function add($data)
    {
        // create product SKU
        $this->model->creating(function ($product) use ($data) {

            $product->sku = $this->generateProductSKU();

            $product->category_id = array_get($data, 'category_id');
            $product->subcategory_id = array_get($data, 'subcategory_id');
            $product->brand_id = array_get($data, 'brand_id');
        });

        return parent::add($data);
    }

    /**
     * Generate a sample product SKU
     *
     * @return string
     */
    public function generateProductSKU()
    {
        return $this->skuString . int_random();
    }

    /**
     * @param $data
     * @param $id
     *
     * @return bool|int
     */
    public function update($data, $id)
    {
        return parent::update($data, $id);
    }

    /**
     * Specify the Model class name
     *
     * @return mixed
     */
    public function model()
    {
        return Product::class;
    }

    /**
     * Displays a listing of all products
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|null
     */
    public function displayAllProducts()
    {
        return $this->paginate(['category', 'subcategory', 'brand', 'reviews'], false, 12);
    }

    /**
     * Displays a sum of individual products in the database
     *
     * @return mixed
     */
    public function getInventoryCount()
    {
        return $this->where('quantity', '<>', '0')->get()->fetch('quantity')->sum();
    }

    /**
     * @param $key
     * @param $operator
     * @param $value
     *
     * @param array $columns
     * @return mixed
     */
    public function where($key, $operator, $value, $columns = ['*'])
    {
        return $this->model->where($key, $operator, $value);
    }

    /**
     * Gets the sum of all products in the db. for instance, if a single product has a qt of 10, we shall get 10 instead of 1
     *
     * @return mixed
     */
    public function getAllProductsCount()
    {

        return $this->all()->count();
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
        return $this->getFirstBy('id', '=', $id, ['category', 'subcategory', 'reviews.user', 'brand']);
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
        $data = $this->with(['reviews'])->whereHas('reviews', function ($q) {

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

        $data = $this->with(['reviews', 'brand'])->where('created_at', '>=', $time)->take(15)->get();

        return $data->sortByDesc(function ($p) {
            return $p->created_at;
        });
    }
}