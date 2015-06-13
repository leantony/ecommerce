<?php namespace App\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;

class OrderWasSubmitted extends Event
{

    use SerializesModels;

    /**
     * @var Collection
     */
    public $order;

    /**
     * Create a new event instance.
     *
     * @param Collection $data
     */
    public function __construct(Collection $data)
    {
        //
        $this->order = $data;
    }

}
