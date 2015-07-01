<?php namespace App\Models;

use app\Antony\DomainLogic\Presenters\NamePresenter;
use Carbon\Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laracasts\Presenter\PresentableTrait;

class SubCategory extends Eloquent
{

    use SoftDeletes, PresentableTrait;

    protected $presenter = NamePresenter::class;

    protected $table = 'subcategories';

    protected $fillable = ['name', 'category_id'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function products()
    {
        return $this->hasMany(\App\Models\Product::class, 'subcategory_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function category()
    {
        return $this->belongsTo(\App\Models\Category::class);
    }

    /**
     * @param $value
     *
     * @return string
     */
    public function getNameAttribute($value)
    {
        return beautify($value);
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