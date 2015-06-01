<?php namespace app\Antony\DomainLogic\Modules\Contact\Base;

use app\Antony\DomainLogic\Contracts\Contact\ContactMessageContract;
use app\Antony\DomainLogic\Contracts\Redirects\AppRedirector;
use app\Antony\DomainLogic\Modules\Contact\ContactMessageRepository;
use app\Antony\DomainLogic\Modules\DAL\Base\DataAccessLayer;
use Illuminate\Http\Request;
use InvalidArgumentException;

class ContactMessagesEntity extends DataAccessLayer implements ContactMessageContract, AppRedirector
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
     * @param $data
     *
     * @return $this
     */
    public function send($data)
    {
        $msg = parent::create($data)->getDataResult();

        if (is_null($msg)) {

            $this->setResult(static::MESSAGE_NOT_SENT);

            return $this;
        }

        $this->setResult(static::MESSAGE_SENT);

        // we store the sent status in the session, to prevent multiple messages from being sent by the same user, in the same session
        session([static::MESSAGE_SENT => true]);

        return $this;
    }

    /**
     * @param $request
     *
     * @return $this|\Illuminate\Http\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function handleRedirect($request)
    {
        if (!$request instanceof Request) {
            throw new InvalidArgumentException('You need to provide a request class to this method');
        }
        switch ($this->getResult()) {

            case static::MESSAGE_SENT: {
                if ($request->ajax()) {
                    return response()->json(['message' => 'Your message was successfully sent'], 200);
                } else {
                    flash('Your message was successfully sent');
                    return redirect()->back();
                }

            }

            case static::MESSAGE_NOT_SENT: {
                if ($request->ajax()) {
                    return response()->json(['message' => 'Oops!. Your message was not sent. Please try again'], 422);
                } else {
                    flash()->error('Oops!. Your message was not sent. Please try again');
                    return redirect()->back()->withInput($request->all());
                }

            }

        }
        return redirect()->back();
    }
}