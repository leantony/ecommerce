<?php namespace app\Http\ViewComposers;

use App\Antony\DomainLogic\Contracts\Caching\CacheInterface;
use App\Antony\DomainLogic\Modules\Composers\ViewComposer;
use app\Antony\DomainLogic\Modules\SubCategories\SubcategoriesRepository;

class FeaturedSmartPhones extends ViewComposer
{
    /**
     * output variable name
     *
     * @var string
     */
    protected $outputVariable = 'featuredPhones';

    /**
     * @param CacheInterface $cacheInterface
     * @param SubCategoriesRepository $repository
     */
    public function __construct(CacheInterface $cacheInterface, SubcategoriesRepository $repository)
    {
        $this->dataSource = $repository;

        $this->cache = $cacheInterface;

        $this->cache->setMinutes(config('site.composers.cache_duration', 10));
    }

    /**
     * Gets the data to display in the view
     *
     * @return mixed
     */
    public function getData()
    {
        return $this->dataSource->displayFeaturedMobilePhones(null);
    }
}