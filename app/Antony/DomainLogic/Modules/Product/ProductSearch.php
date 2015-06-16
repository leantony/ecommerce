<?php namespace app\Antony\DomainLogic\Modules\Product;

use app\Antony\DomainLogic\Modules\Search\Search;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use InvalidArgumentException;

class ProductSearch extends Search
{

    /**
     * pagination option
     *
     * @var boolean
     */
    public $paginate = true;

    /**
     * Defines if we should use AJAX
     *
     * @var boolean
     */
    public $useAJAX = false;

    /**
     * The amount of results to display during AJAX suggestive search
     *
     * @var int
     */
    public $ajaxResultsLimit = 7;

    /**
     * Search keywords
     *
     * @var string
     */
    protected $keywords = '';

    /**
     * Search results view
     *
     * @var string
     */
    protected $resultsView = 'frontend.products.index';

    /**
     * Empty search results view
     *
     * @var string
     */
    protected $outputResultsVariableName = 'products';

    /**
     * Empty results message
     *
     * @var string
     */
    protected $emptyResultMessage = "sorry. we found no products matching";

    /**
     * @param ProductRepository $repository
     */
    public function __construct(ProductRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Integrates all search functionality into 1 function, by chaining them
     *
     * @param Request $request
     *
     * @return $this|\Illuminate\View\View
     */
    public function search(Request $request)
    {
        $this->getKeywordsFromRequest($request);

        // check if the query contains sth we can use as an SKU. our SKU looks like ...PCW123456789
        $sku = starts_with($this->keywords, 'PCW') ? $this->keywords : null;

        $this->keywords = strtolower($this->keywords);

        if (is_null($sku)) {
            // initialize normal search
            if ($this->useAJAX) {
                return $this->findProduct();
            }
            return $this->findProduct()->processResult($this->results);
        } else {
            // search by SKU
            if ($this->useAJAX) {
                return $this->searchBySku($sku);
            }
            return $this->searchBySku($sku)->processResult($this->results);
        }
    }

    /**
     * Does the actual fetching of data, from the DB
     *
     * @return $this
     */
    protected function findProduct()
    {
        // in both instances below, we search both the name, and description, in order to widen our results
        if ($this->paginate) {

            if ($this->useAJAX) {
                throw new InvalidArgumentException('For now, the AJAX request returns a single result, so please disable pagination first');
            }

            $this->results
                = $this->includeProductRelationships()->where('name', 'LIKE', '%' . $this->keywords . '%')
                ->orWhere('description_short', 'LIKE', '%' . $this->keywords . '%')
                ->orWhere('description_long', 'LIKE', '%' . $this->keywords . '%')
                ->get();

            $this->results = $this->paginateCollection($this->results, $this->paginationLength, $this->searchRequest);

            $this->appendQueryStringToPaginatedSet($this->results, 'q', $this->keywords);

            return $this;
        }

        $this->results =
            $this->repository->where('name', 'LIKE', '%' . $this->keywords . '%')
                ->orWhere('description_short', 'LIKE', '%' . $this->keywords . '%')
                ->orWhere('description_long', 'LIKE', '%' . $this->keywords . '%')
                ->get()->take($this->ajaxResultsLimit);

        return $this;

    }

    /**
     * Defines what relationships we shall include with the fetched data
     *
     * @return \Illuminate\Database\Eloquent\Builder|static
     */
    public function includeProductRelationships()
    {
        return $this->repository->with(['category', 'subcategory', 'reviews']);
    }

    /**
     * Process the search results
     *
     * @param $result
     *
     * @return $this|\Illuminate\View\View
     */
    public function processResult($result)
    {
        // no search results
        if (empty($this->getResult())) {
            flash($this->emptyResultMessage . " " . $this->keywords);

            return view($this->emptyResultsView);
        }

        // check if we have a paginated result set. This will imply that the result consisted
        // of more than 1 product
        if ($this->getResult() instanceof LengthAwarePaginator) {

            return view('frontend.products.index')->with($this->outputResultsVariableName, $this->results);
        }

        return view('frontend.products.single')->with($this->outputResultsVariableName, $this->results);

    }

    /**
     * Allows a user to search for a product by SKU
     *
     * @param $sku
     *
     * @return $this
     */
    public function searchBySku($sku)
    {
        $this->outputResultsVariableName = 'product';
        // we only expect a single product, so we use the single products view
        $this->resultsView = 'frontend.products.single';

        $this->results = $this->repository->getFirstBy('sku', '=', $sku, ['category', 'subcategory', 'reviews']);

        return $this;
    }

    /**
     * @return mixed|\Symfony\Component\HttpFoundation\Response
     */
    public function processAJAXRequest()
    {
        // check if AJAX searching is turned on
        if ($this->useAJAX) {

            // we format the JSON returned to match the wonderful devbridge plugin used to provide auto-complete functionality
            $suggestions = [];

            // check if the results are a collection. No need to display suggestions for stuff like SKU search which is available
            if ($this->results instanceof Collection) {
                foreach ($this->results as $product) {
                    $suggestions[] = [
                        "value" => $product->name,
                        "data" => $product->id,
                        'redirect' => route('product.view', ['product' => $product->id]),
                    ];
                }
            }

            return response()->json(['suggestions' => $suggestions]);
        }

        return $this->results;
    }
}
