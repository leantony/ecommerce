<?php namespace App\Handlers\Events;

use App\Events\OrderWasSubmitted;
use Illuminate\Mail\Mailer;

class SendOrderReceiptEmail
{

    /**
     * @var Mailer
     */
    private $mailer;

    /**
     * Create the event handler.
     *
     * @return void
     */
    public function __construct(Mailer $mailer)
    {
        //
        $this->mailer = $mailer;
    }

    /**
     * Handle the event.
     *
     * @param  OrderWasSubmitted $event
     *
     * @return void
     */
    public function handle(OrderWasSubmitted $event)
    {
        $order = $event->order->get('0');

        $user = $event->order->get('1');

        $products = $event->order->get('2');

        $receiver = $user->email;

        $subject = "Invoice for your order dated {$order->created_at}";

        $data = ['order' => $order, 'user' => $user, 'products' => $products];

        $this->mailer->queue('emails.invoice', compact('data'), function ($m) use ($receiver, $subject) {
            $m->to($receiver);
            $m->subject($subject);
        });
    }

}
