<?php namespace app\Antony\DomainLogic\Modules\Brands;

use app\Antony\DomainLogic\Modules\DAL\EloquentRepository;
use App\Models\Brand;

class BrandsRepository extends EloquentRepository
{

    /**
     * Specify the Model class name
     *
     * @return mixed
     */
    public function model()
    {
        return 'App\Models\Brand';
    }
}