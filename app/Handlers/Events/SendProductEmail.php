<?php namespace App\Handlers\Events;

use App\Events\productMailRequested;
use Illuminate\Mail\Mailer;
use Illuminate\Queue\InteractsWithQueue;

class SendProductEmail
{

    use InteractsWithQueue;

    protected $mailer;

    /**
     * Create the event handler.
     *
     * @return void
     */
    public function __construct(Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    /**
     * Handle the event.
     *
     * @param  productMailRequested $event
     *
     * @return void
     */
    public function handle(productMailRequested $event)
    {
        $user = $event->user;

        $receiver = $event->recipient;
        $subject = "Checkout the " . beautify($event->product->name);

        $data = ['sender' => $user, 'product' => $event->product];

        $this->mailer->queue('emails.view-product', compact('data'), function ($m) use ($receiver, $subject) {
            $m->to($receiver);
            $m->subject($subject);
        });
    }

}
