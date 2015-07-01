<?php

namespace app\Antony\DomainLogic\Modules\Audit;

use app\Antony\DomainLogic\Modules\DAL\EloquentRepository;
use App\Models\Event;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Trail extends EloquentRepository
{

    protected $event;

    protected $actor;

    // get event name
    public function getEventName()
    {
        $this->event = \Event::firing();

        return $this->event;
    }

    // get event actor
    public function getEventActor()
    {
        if (auth()->check()) {

            $this->actor = auth()->user()->getAuthIdentifier();

            return $this->actor;
        }

        $this->actor = 0;

        return $this->actor;
    }

    // save event in events table -> insert if not exist
    public function saveEvent()
    {
        return $this->getModel()->firstOrCreate(['name' => $this->event]);
    }

    public function saveEventInformation(array $data)
    {


    }


    public function getEventData(){
        // timestamp
        $timestamp = Carbon::now()->timestamp;
        $actor_id = $this->actor;
        $source_ip = \Request::getClientIps();
        $port = \Request::getPort();
        $duration = 'unknown';
    }

    // update the info table

    /**
     * Specify the Model class name
     *
     * @return mixed
     *
     */public function model()
    {
        return Event::class;
    }
}