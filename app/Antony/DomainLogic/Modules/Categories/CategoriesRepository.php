<?php namespace app\Antony\DomainLogic\Modules\Categories;

use app\Antony\DomainLogic\Modules\DAL\EloquentRepository;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class CategoriesRepository extends EloquentRepository
{

    /**
     * Specify the Model class name
     *
     * @return mixed
     */
    public function model()
    {
        return Category::class;
    }


    /**
     * Displays a listing of categories, with their subcategories. This is for the site navigation bar
     *
     * @return mixed
     */
    public function displayCategoryListing()
    {
        return $this->with(['subcategories'])->paginate();
    }


    /**
     * Really self explanatory. Displays products within a category
     *
     * @param $category_id
     * @param Request $request
     *
     * @return array
     */
    public function displayCategoryAndRelatedProducts($category_id, Request $request)
    {
        $data = $category_id instanceof Category ?
            $category_id->with('products.subcategory', 'products.reviews', 'products.brand')->whereId($category_id->id)->get()
            : $this->with(['products.subcategory', 'products.reviews', 'products.brand'])->whereId($category_id)->get();

        $collection = new Collection();

        $cat = '';

        foreach ($data as $category) {

            $cat = $category;
            foreach ($category->products as $product) {

                $collection->push($product);
            }

        }

        $pages = $this->paginateCollection($collection, 5, $request);

        return compact('pages', 'cat');
    }

    /**
     * Displays categories on the site's navigation bar
     *
     * @return mixed
     */
    public function displayCategories()
    {
        $data = $this->with(['subcategories'])->take(5)->orderBy('name', 'asc')->get();

        return $data;
    }
}