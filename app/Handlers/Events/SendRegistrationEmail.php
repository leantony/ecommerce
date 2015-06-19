<?php namespace App\Handlers\Events;

use App\Events\UserWasRegistered;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailer;
use Illuminate\Queue\InteractsWithQueue;

class SendRegistrationEmail implements ShouldQueue
{
    use InteractsWithQueue;

    protected $mailer;

    /**
     * Create the event handler.
     *
     * @param Mailer $mailer
     */
    public function __construct(Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    /**
     * Handle the event.
     *
     * @param  UserWasRegistered $event
     *
     * @return mixed
     */
    public function handle(UserWasRegistered $event)
    {
        $user = $event->user;

        $receiver = $user->email;
        $subject = $this->subject();

        $data =
            [
                'user' => $user->present()->firstName,
                'code' => $user->confirmation_code,
                'link_' => secure_url(route('account.activate', ['code' => $user->confirmation_code]))
            ];

        return $this->mailer->queue('emails.activation', compact('data'), function ($m) use ($receiver, $subject) {
            $m->to($receiver);
            $m->subject($subject);
        });

    }

    /**
     * @return string
     */
    public function subject()
    {

        return "Welcome to PC-World";
    }

}
