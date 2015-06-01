<?php namespace app\http\ViewComposers;

use App\Antony\DomainLogic\Contracts\Caching\CacheInterface;
use app\Antony\DomainLogic\Modules\Brands\Base\BrandsEntity;
use App\Antony\DomainLogic\Modules\Composers\ViewComposer;

class BrandsList extends ViewComposer
{
    /**
     * output variable name
     *
     * @var string
     */
    protected $outputVariable = 'brands';

    /**
     * @param CacheInterface $cacheInterface
     * @param BrandsEntity $repository
     */
    public function __construct(CacheInterface $cacheInterface, BrandsEntity $repository)
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
        return $this->dataSource->displayBrandsOnHomePage();
    }
}