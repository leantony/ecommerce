<?php namespace app\Antony\DomainLogic\Modules\Counties;

use app\Antony\DomainLogic\Modules\DAL\EloquentRepository;
use App\Models\County;

class CountiesRepository extends EloquentRepository
{


    /**
     * Specify the Model class name
     *
     * @return mixed
     */
    public function model()
    {
        return County::class;
    }
}