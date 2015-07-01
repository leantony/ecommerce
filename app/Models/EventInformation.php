<?php

namespace App\Models;


class EventInformation extends \Eloquent{

    public function event(){

        return $this->belongsTo(\App\Models\Event::class);
    }
}
