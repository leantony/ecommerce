<?php namespace App\Models;

use Eloquent;

class AnonymousMessages extends Eloquent
{

    protected $fillable = [
        'message',
        'subject',
        'user_name',
        'email'
    ];

}