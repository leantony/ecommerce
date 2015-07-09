<?php namespace App\Models;

use app\Antony\DomainLogic\Modules\Product\Traits\ProductReconciler;
use app\Antony\DomainLogic\Modules\Product\Traits\ProductReviewsTrait;
use app\Antony\DomainLogic\Modules\Product\Traits\ProductTrait;
use app\Antony\DomainLogic\Modules\ShoppingCart\Discounts\PercentageDiscount;
use app\Antony\DomainLogic\Modules\ShoppingCart\Traits\DiscountsTrait;
use app\Antony\DomainLogic\Presenters\NamePresenter;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laracasts\Presenter\PresentableTrait;
use Money\Currency;
use Money\Money;

class Product extends \Eloquent
{
    use PresentableTrait;

    use ProductTrait, DiscountsTrait, ProductReviewsTrait, SoftDeletes, ProductReconciler;

    protected $presenter = NamePresenter::class;

    // public $incrementing = false;

    protected $fillable = [
        'name',
        'price',
        'discount',
        'quantity',
        'description_long',
        'description_short',
        'stuff_included',
        'warranty_period',
        'image',
        'category_id',
        'subcategory_id',
        'brand_id'
    ];

    protected $casts = [
        'available' => 'boolean',
        'free' => 'boolean',
        'taxable' => 'boolean',
        'zoomable' => 'boolean'
    ];

    /**
     * @param $value
     *
     * @return mixed
     */
    public function getDescriptionShortAttribute($value)
    {
        return is_serialized($value) ? unserialize($value) : $value;
    }

    /**
     * @param $value
     *
     * @return mixed
     */
    public function getDescriptionLongAttribute($value)
    {
        return is_serialized($value) ? unserialize($value) : $value;
    }

    /**
     * @param $value
     *
     * @return Money
     */
    public function getPriceAttribute($value)
    {
        $value = new Money((int)$value, new Currency(config('site.money.default_currency', 'KES')));

        return $value;
    }

    /**
     * @param $value
     *
     * @return int
     */
    public function getTaxableAttribute($value)
    {
        return $value === 1;
    }

    /**
     * @param $value
     *
     * @return Money
     */
    public function getShippingAttribute($value)
    {
        return new Money((int)$value, new Currency(config('site.money.default_currency', 'KES')));
    }

    /**
     * @param $value
     *
     * @return PercentageDiscount
     */
    public function getDiscountAttribute($value)
    {
        return new PercentageDiscount($value);
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

    // RELATIONSHIPS

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function category()
    {
        return $this->belongsTo(\App\Models\Category::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function brand()
    {
        return $this->belongsTo(\App\Models\Brand::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function subcategory()
    {
        return $this->belongsTo(\App\Models\SubCategory::class, 'subcategory_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function reviews()
    {
        return $this->hasMany(\App\Models\Review::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function carts()
    {
        return $this->belongsToMany(\App\Models\Cart::class)->withPivot('quantity')->withTimestamps();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function orders()
    {
        return $this->belongsToMany(\App\Models\Order::class)->withPivot('quantity')->withTimestamps();
    }

}
