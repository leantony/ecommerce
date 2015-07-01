<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    public function information(){

        return $this->hasMany(\App\Models\EventInformation::class);
    }
}
