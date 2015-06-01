<?php namespace app\Models;

use Carbon\Carbon;
use Eloquent;

class Order extends Eloquent
{
    //use SoftDeletes;

    public $incrementing = false;

    protected $casts = [
        'status',
        'done'
    ];

    /**
     * @param $value
     *
     * @return string
     */
    public function setDataAttribute($value)
    {
        $this->attributes['data'] = is_serialized($value) ? $value : serialize($value);
    }

    /**
     * @param $value
     *
     * @return mixed
     */
    public function getDataAttribute($value)
    {
        return is_serialized($value) ? unserialize($value) : $value;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function products()
    {
        return $this->belongsToMany('App\Models\product')->withTimestamps()->withPivot('quantity');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany('App\Models\User')->withTimestamps();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function guests()
    {
        return $this->belongsToMany('App\Models\Guest')->withTimestamps();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function invoice()
    {
        return $this->hasOne('App\Models\Invoice');
    }

    /**
     * @param $value
     *
     * @return string
     */
    public function getUpdatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('l jS F Y h:i:s A');
    }

    /**
     * @param $value
     *
     * @return string
     */
    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('l jS F Y h:i:s A');
    }
}