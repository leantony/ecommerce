<?php namespace app\Antony\DomainLogic\Modules\Counties\Base;

use app\Antony\DomainLogic\Modules\Counties\CountiesRepository;
use app\Antony\DomainLogic\Modules\DAL\Base\DataAccessLayer;

class CountyEntity extends DataAccessLayer
{
    /**
     * Object name that will be displayed in the redirect msg
     *
     * @var string
     */
    protected $objectName = 'counties';

    /**
     * @param CountiesRepository $countiesRepository
     */
    public function __construct(CountiesRepository $countiesRepository)
    {
        parent::__construct($countiesRepository);
    }

    /**
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|null
     */
    public function get()
    {
        return $this->repository->paginate();
    }
}