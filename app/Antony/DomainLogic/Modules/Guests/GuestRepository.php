<?php namespace app\Antony\DomainLogic\Modules\Guests;

use app\Antony\DomainLogic\Modules\DAL\EloquentRepository;
use App\Models\Guest;

class GuestRepository extends EloquentRepository
{

    /**
     * @param $data
     * @param null $id
     *
     * @return EloquentRepository|\Illuminate\Database\Eloquent\Model
     */
    public function addGuest($data, $id = null)
    {
        return parent::addIfNotExist($id, $data);
    }

    /**
     * Specify the Model class name
     *
     * @return mixed
     */
    public function model()
    {
        return Guest::class;
    }
}