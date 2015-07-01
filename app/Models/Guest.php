<?php namespace App\Models;

use Eloquent;

class Guest extends Eloquent
{
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'county_id',
        'home_address',
        'town',
    ];

    /**
     * @return string
     */
    public function getUserName()
    {
        return beautify($this->first_name . " " . $this->last_name);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function county()
    {
        return $this->belongsTo(\App\Models\County::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function orders()
    {
        return $this->belongsToMany(\App\Models\Order::class);
    }
}