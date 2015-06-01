<?php namespace app\Antony\DomainLogic\Modules\Categories;

use app\Antony\DomainLogic\Modules\DAL\EloquentRepository;
use App\Models\Category;

class CategoriesRepository extends EloquentRepository
{

    /**
     * Specify the Model class name
     *
     * @return mixed
     */
    public function model()
    {
        return 'App\Models\Category';
    }
}