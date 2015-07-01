<?php namespace App\Models;


use app\Antony\DomainLogic\Presenters\NamePresenter;
use Carbon\Carbon;
use Eloquent;
use Laracasts\Presenter\PresentableTrait;

class Brand extends Eloquent
{

    use PresentableTrait;

    protected $presenter = NamePresenter::class;

    protected $fillable = ['name', 'logo'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function products()
    {
        return $this->hasMany(\App\Models\Product::class);
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