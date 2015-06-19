<?php namespace App\Handlers\Events;

use App\Events\UserWasLoggedIn;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class LogUserEvent
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  UserWasLoggedIn  $event
     * @return boolean
     */
    public function handle(User $user)
    {
        return $this->updateLoginTime($user);
    }

    /**
     * @return mixed
     */
    public function updateLoginTime($user){

        $user->last_login = Carbon::now();

        return $user->save();
    }
}
