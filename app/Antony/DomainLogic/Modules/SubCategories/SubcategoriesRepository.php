<?php namespace app\Antony\DomainLogic\Modules\SubCategories;

use app\Antony\DomainLogic\Modules\DAL\EloquentRepository;

class SubcategoriesRepository extends EloquentRepository
{

    /**
     * Specify the Model class name
     *
     * @return mixed
     */
    public function model()
    {
        return 'App\Models\SubCategory';
    }
}