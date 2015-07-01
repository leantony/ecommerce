<?php namespace app\Models;

use Eloquent;

class Invoice extends Eloquent
{

    public $incrementing = false;

    public $fillable = ['data'];

    /**
     * @param $data
     */
    public function setDataAttribute($data)
    {
        $this->attributes['data'] = is_serialized($data) ? $data : serialize($data);
    }

    /**
     * @param $data
     *
     * @return mixed
     */
    public function getDataAttribute($data)
    {
        return unserialize($data);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function order()
    {

        return $this->belongsTo(\App\Models\Order::class);
    }
}