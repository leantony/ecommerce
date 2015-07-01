<?php namespace App\Models;

use App\Antony\DomainLogic\Modules\User\UserTrait;
use app\Antony\DomainLogic\Presenters\UserPresenter;
use Eloquent;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laracasts\Presenter\PresentableTrait;
use Zizaco\Entrust\Traits\EntrustUserTrait;

class User extends Eloquent implements AuthenticatableContract, CanResetPasswordContract
{

    use PresentableTrait, Authenticatable, CanResetPassword, EntrustUserTrait, UserTrait;

    protected $presenter = UserPresenter::class;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'phone',
        'county_id',
        'home_address',
        'town',
        'avatar',
        'dob',
        'gender'
    ];

    protected $guarded = ['id', 'confirmed', 'confirmation_code'];

    protected $casts = [
        'confirmed' => 'boolean',
        'disabled' => 'boolean',
    ];

    /**
     * @return array
     */
    public function getDates()
    {
        return ['created_at', 'updated_at', 'confirmed_at', 'deleted_at', 'last_login'];
    }

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token', 'confirmation_code'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function reviews()
    {
        return $this->hasMany(\App\Models\Review::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function county()
    {
        return $this->belongsTo(\App\Models\County::class);
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function shopping_cart()
    {
        return $this->hasOne(\App\Models\Cart::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orders()
    {
        return $this->belongsToMany(\App\Models\Order::class)->withTimestamps();
    }

}
