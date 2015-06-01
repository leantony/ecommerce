<?php namespace app\Antony\DomainLogic\Modules\Composers;

use app\Antony\DomainLogic\contracts\caching\CacheInterface;
use app\Antony\DomainLogic\Contracts\ViewComposer\ComposerInterface;
use Illuminate\View\View;
use InvalidArgumentException;

abstract class ViewComposer implements ComposerInterface
{

    /**
     * output variable name
     *
     * @var string
     */
    protected $outputVariable;

    /**
     * Cache implementation
     *
     * @var CacheInterface
     */
    protected $cache;

    /**
     * data source
     *
     * @var Object
     */
    protected $dataSource;

    /**
     * Compose the View
     *
     * @param View $view
     *
     * @return mixed
     */
    public function compose(View $view)
    {
        // check if any args to be provided by extending classes are provided
        $this->checkArguments();

        $key = h($this->outputVariable);

        if ($this->cache->has($key)) {
            $view->with($this->outputVariable, $this->cache->get($key));

        } else {

            $data = $this->getData();

            $this->cache->put($key, $data);

            $view->with($this->outputVariable, $data);
        }
    }

    /**
     * Checks if any of our needed args are good
     */
    protected function checkArguments()
    {
        if (is_null($this->outputVariable)) {

            throw new InvalidArgumentException('The output variable cannot be null');
        }

        if (is_null($this->cache)) {

            throw new InvalidArgumentException("By default, we cache the composer data for 10 minutes. But you haven't provided any caching mechanism");
        }
    }

    /**
     * Gets the data from the data source provided, which will be displayed in the view
     *
     * @return mixed
     */
    abstract public function getData();
}