<?php namespace app\Antony\DomainLogic\Modules\Contact;

use app\Antony\DomainLogic\Contracts\Contact\ContactMessageContract;
use app\Antony\DomainLogic\Modules\DAL\EloquentRepository;
use App\Models\AnonymousMessages;

class ContactMessageRepository extends EloquentRepository implements ContactMessageContract
{

    /**
     * Specify the Model class name
     *
     * @return mixed
     */
    public function model()
    {
        return AnonymousMessages::class;
    }

    /**
     * Send the contact message
     *
     * @param $data
     *
     * @return $this
     */
    public function send($data)
    {
        $msg = parent::create($data);

        // we store the sent status in the session, to prevent multiple messages from being sent by the same user, in the same session
        session(['message.sent' => true]);

        return $msg;
    }
}