<?php namespace app\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;

class Article extends \Eloquent
{

    use SoftDeletes;

    protected $fillable = ['content', 'topic'];

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