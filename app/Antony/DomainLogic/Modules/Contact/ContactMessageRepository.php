<?php namespace app\Antony\DomainLogic\Modules\Contact;

use app\Antony\DomainLogic\Modules\DAL\EloquentRepository;
use App\Models\AnonymousMessages;

class ContactMessageRepository extends EloquentRepository
{

    /**
     * @param AnonymousMessages $anonymousMessages
     */
    public function __construct(AnonymousMessages $anonymousMessages)
    {
        parent::__construct($anonymousMessages);
    }
}