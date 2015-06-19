<?php namespace App\Handlers\Events;

use App\Events\PasswordResetWasRequested;
use Illuminate\Auth\Passwords\TokenRepositoryInterface;
use Illuminate\Mail\Mailer;
use Illuminate\Queue\InteractsWithQueue;

class SendPasswordResetEmail
{

    use InteractsWithQueue;

    protected $mailer;

    protected $tokens;

    /**
     * Create the event handler.
     *
     * @param Mailer $mailer
     * @param TokenRepositoryInterface $tokens
     */
    public function __construct(Mailer $mailer, TokenRepositoryInterface $tokens)
    {
        $this->mailer = $mailer;

        $this->tokens = $tokens;
    }

    /**
     * Handle the event.
     *
     * @param  PasswordResetWasRequested $event
     *
     * @return mixed
     */
    public function handle(PasswordResetWasRequested $event)
    {
        $subject = $this->subject();

        $token = $this->tokens->create($event->user);

        $recipient = $event->user->email;

        $data = ['username' => $event->user->present()->fullName, 'token' => $token];

        return $this->mailer->queue('emails.password', compact('data'), function ($m) use ($recipient, $subject) {
            $m->to($recipient);

            $m->subject($subject);

        });
    }

    /**
     * @return string
     */
    public function subject()
    {
        return "Password reset information";
    }
}
