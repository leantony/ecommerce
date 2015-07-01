<?php namespace app\Models;

use Eloquent;

class Order extends Eloquent
{
    //use SoftDeletes;

    public $incrementing = false;

    protected $casts = [
        'delivered' => 'boolean',
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
        return $this->belongsToMany(\App\Models\product::class)->withTimestamps()->withPivot('quantity');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany(\App\Models\User::class)->withTimestamps();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function guests()
    {
        return $this->belongsToMany(\App\Models\Guest::class)->withTimestamps();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function invoice()
    {
        return $this->hasOne(\App\Models\Invoice::class);
    }

}