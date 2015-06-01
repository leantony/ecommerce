<?php namespace App\Events;

use App\Events\Event;

use App\Models\Product;
use App\Models\User;
use Illuminate\Queue\SerializesModels;

class productMailRequested extends Event {

	use SerializesModels;

    public $product;

    public $user;

    public $recipient;

    /**
     * Create a new event instance.
     *
     * @param Product $product
     * @param User $user
     * @param $recipient
     */
	public function __construct(Product $product, User $user, $recipient)
	{
		$this->product = $product;

        $this->user = $user;

        $this->recipient = $recipient;
	}

}
