<?php namespace app\http\ViewComposers;

use App\Antony\DomainLogic\Contracts\Caching\CacheInterface;
use app\Antony\DomainLogic\Modules\Categories\Base\CategoryEntity;
use App\Antony\DomainLogic\Modules\Composers\ViewComposer;
use App\Models\Category;

class CategoryList extends ViewComposer
{
    /**
     * output variable name
     *
     * @var string
     */
    protected $outputVariable = 'categories';

    /**
     * @param CacheInterface $cacheInterface
     * @param CategoryEntity $categories
     */
    public function __construct(CacheInterface $cacheInterface, CategoryEntity $categories)
    {

        $this->cache = $cacheInterface;
        $this->dataSource = $categories;

        $this->cache->setMinutes(config('site.composers.cache_duration', 10));
    }

    /**
     * Gets the data to display in the view
     *
     * @return mixed
     */
    public function getData()
    {
        return $this->dataSource->displayCategories();
    }
}