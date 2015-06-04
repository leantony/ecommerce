<?php namespace app\Antony\DomainLogic\Modules\Contact;

use app\Antony\DomainLogic\Modules\DAL\EloquentRepository;
use App\Models\AnonymousMessages;

class ContactMessageRepository extends EloquentRepository
{


    /**
     * Specify the Model class name
     *
     * @return mixed
     */
    public function model()
    {
        return 'App\Models\AnonymousMessages';
    }
}