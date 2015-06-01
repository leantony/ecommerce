<?php namespace app\Antony\DomainLogic\Modules\Articles\Base;

use app\Antony\DomainLogic\Modules\Articles\ArticlesRepository;
use app\Antony\DomainLogic\Modules\DAL\Base\DataAccessLayer;

class ArticlesEntity extends DataAccessLayer
{

    /**
     * @param ArticlesRepository $articlesRepository
     */
    public function __construct(ArticlesRepository $articlesRepository)
    {

        parent::__construct($articlesRepository);

    }

    /**
     * Ok, this presents a commonly used implementation of a SELECT procedure
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|null
     */
    public function get()
    {
        return $this->repository->paginate();
    }
}