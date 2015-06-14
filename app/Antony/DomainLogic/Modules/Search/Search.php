<?php namespace app\Antony\DomainLogic\Modules\Search;

use app\Antony\DomainLogic\Contracts\Database\RepositoryInterface;
use app\Antony\DomainLogic\Contracts\Search\SearchRepositoryInterface;
use app\Antony\DomainLogic\Modules\DAL\EloquentExtensions;
use Illuminate\Http\Request;

abstract class Search implements SearchRepositoryInterface
{

    use EloquentExtensions;

    /**
     * The underlying repository
     *
     * @var RepositoryInterface
     */
    protected $repository;

    /**
     * Search keywords
     *
     * @var string
     */
    protected $keywords = "";

    /**
     * pagination option
     *
     * @var boolean
     */
    protected $paginate = true;

    /**
     * Length of the paginated data set
     *
     * @var int
     */
    protected $paginationLength = 10;

    /**
     * The variable that will be output to the view
     *
     * @var string
     */
    protected $outputResultsVariableName = 'results';

    /**
     * Search results
     *
     * @var mixed
     */
    protected $results = null;

    /**
     * Search results view
     *
     * @var string
     */
    protected $resultsView;

    /**
     * Defines if we should use AJAX
     *
     * @var boolean
     */
    protected $useAJAX;

    /**
     * The request object that contains the GET search param
     *
     * @var string
     */
    protected $requestObject = 'q';

    /**
     * The request object
     *
     * @var Request
     */
    protected $searchRequest = null;

    /**
     * Empty results message
     *
     * @var string
     */
    protected $emptyResultMessage = 'sorry. we could not find what you searched for';

    /**
     * Empty search results view
     *
     * @var string
     */
    protected $emptyResultsView = 'frontend.search.index';

    /**
     * @return null
     */
    public function getResult()
    {
        return $this->results;
    }

    /**
     * @return string
     */
    public function getRequestObject()
    {
        return $this->requestObject;
    }

    /**
     * @param boolean $requestObject
     */
    public function setRequestObject($requestObject)
    {
        $this->requestObject = $requestObject;
    }

    /**
     * @param Request $request
     *
     * @return $this
     */
    public function getKeywordsFromRequest(Request $request)
    {
        $this->searchRequest = $request;

        $this->keywords = $this->searchRequest->get($this->getRequestObject());

        return $this;
    }

    /**
     * @param $set
     * @param $key
     * @param $value
     *
     * @return mixed
     */
    public function appendQueryStringToPaginatedSet($set, $key, $value)
    {
        return $set->appends($key, $value);
    }
}