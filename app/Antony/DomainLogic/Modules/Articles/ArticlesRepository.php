<?php namespace app\Antony\DomainLogic\Modules\Articles;

use app\Antony\DomainLogic\Modules\DAL\EloquentRepository;
use App\Models\Article;

class ArticlesRepository extends EloquentRepository
{

    /**
     * Specify the Model class name
     *
     * @return mixed
     */
    public function model()
    {
        return Article::class;
    }
}