<?php namespace App\Models;

use app\Antony\DomainLogic\Modules\ShoppingCart\Traits\ReconcilerTrait;


class Cart extends \Eloquent
{
    use ReconcilerTrait;

    public $incrementing = false;

    protected $fillable = ['product_id', 'cart_id', 'quantity'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function products()
    {
        return $this->belongsToMany(\App\Models\Product::class)->withPivot('quantity')->withTimestamps();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }
}