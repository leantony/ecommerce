<?php namespace App\Models;

use app\Antony\DomainLogic\Presenters\NamePresenter;
use Carbon\Carbon;
use Eloquent;
use Laracasts\Presenter\PresentableTrait;

class County extends Eloquent
{
    use PresentableTrait;

    protected $presenter = NamePresenter::class;

    protected $fillable = ['name', 'alias'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function users()
    {
        return $this->hasMany(\App\Models\User::class);
    }

    /**
     * @param $value
     *
     * @return string
     */
    public function getNameAttribute($value)
    {
        return ucfirst($value);
    }

    /**
     * @param $value
     *
     * @return string
     */
    public function getUpdatedAtAttribute($value)
    {
        return Carbon::parse($value)->diffForHumans();
    }

    /**
     * @param $value
     *
     * @return string
     */
    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->diffForHumans();
    }

    /**
     * @param $value
     *
     * @return string
     */
    public function getDeletedAtAttribute($value)
    {
        return Carbon::parse($value)->diffForHumans();
    }
}