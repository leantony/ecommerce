<?php namespace app\Antony\DomainLogic\Modules\Brands;

use app\Antony\DomainLogic\Modules\DAL\EloquentRepository;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class BrandsRepository extends EloquentRepository
{

    /**
     * Specify the Model class name
     *
     * @return mixed
     */
    public function model()
    {
        return Brand::class;
    }

    /**
     * Displays a listing of all brands
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|null
     */
    public function displayAllBrands()
    {
        return parent::paginate(['products']);
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
            $data = $this->with(['products.category', 'products.reviews', 'products.subcategory'])->where('id', $brand_id)->get();
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
        $data = parent::where('logo', '<>', 'null')->sortBy('name');

        return $data;
    }
}