<?php namespace app\Antony\DomainLogic\Modules\Contact\Base;

use app\Antony\DomainLogic\Contracts\Contact\ContactMessageContract;
use app\Antony\DomainLogic\Contracts\Redirects\AppRedirector;
use app\Antony\DomainLogic\Modules\Contact\ContactMessageRepository;
use app\Antony\DomainLogic\Modules\DAL\Base\DataAccessLayer;
use Illuminate\Http\Request;
use InvalidArgumentException;

class ContactMessagesEntity extends DataAccessLayer implements ContactMessageContract
{
    /**
     * @param ContactMessageRepository $messageRepo
     */
    public function __construct(ContactMessageRepository $messageRepo)
    {
        parent::__construct($messageRepo);

    }

    /**
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|null
     */
    public function get()
    {
        // TODO: Implement get() method.
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