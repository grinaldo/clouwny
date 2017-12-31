<?php

namespace App\Model;

use Illuminate\Notifications\Notifiable;
use App\Model\BaseModel;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends BaseModel implements
    AuthenticatableContract,
    AuthorizableContract,
    CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword;
    use Notifiable;

    protected $table = 'users';

    const ROLE_SUPER_ADMIN  = 1;
    const ROLE_ADMIN        = 2;
    const ROLE_MODERATOR    = 3;
    const ROLE_USER         = 9;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'role',
        'name', 
        'username',
        'email', 
        'password',
        'active',
        'gender',
        'phone',
        'birthday',
        'province',
        'city',
        'district',
        'zipcode',
        'address',
        'wallet'
    ];

    protected $urlKey = 'id';

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    // public function setPasswordAttribute($value)
    // {
    //     if (!empty($value) || is_numeric($value)) {
    //         $this->attributes['password'] = \Hash::make($value);
    //     }
    // }

    public function getGroupTypeAttribute()
    {
        if (!isset($this->attributes['role'])) {
            return null;
        }

        $group = $this->attributes['role'];
        if (!is_numeric($group)) {
            return -1;
        }
        return (int)$group;
    }

    public function isSuper()
    {
        return $this->role === self::ROLE_SUPER_ADMIN;
    }

    public function isAdmin()
    {
        return $this->role === self::ROLE_SUPER_ADMIN || $this->role === self::ROLE_ADMIN || $this->role === self::ROLE_MODERATOR;
    }

    public function isUser()
    {
        return $this->role === self::ROLE_USER;
    }

    public function login()
    {
        if ($this->current_log_in_at !== null) {
            $this->last_log_in_at = $this->current_log_in_at;
            $this->last_log_in_ip = $this->current_log_in_ip;
        }

        $this->current_log_in_at = Carbon::now();
        $this->current_log_in_ip = \Request::getClientIp();
        $this->save();

        $this->increment('log_in_count');
    }

    public function logout()
    {
        $this->last_log_in_at = Carbon::now();
        $this->last_log_in_ip = \Request::getClientIp();
        $this->current_log_in_at = null;
        $this->current_log_in_ip = '';
        $this->save();
    }

    public function getName()
    {
        return $this->name;
    }

    public static function groups()
    {
        return [
            static::ROLE_USER           => 'User',
            static::ROLE_SUPER_ADMIN    => 'Super Administrator',
            static::ROLE_ADMIN          => 'Administrator',
            static::ROLE_MODERATOR      => 'Moderator',
        ];
    }

    public function getGroupName()
    {
        if (!in_array($this->role, array_keys(static::groups()))) {
            throw new \Exception('Group type [' . $this->role . '] is not defined');
        }

        return static::groups()[$this->role];
    }

    public function scopeNotMe($query)
    {
        if (\Auth::check()) {
            return $query->where('id', '<>', \Auth::user()->id);
        }
    }

    public function isMe()
    {
        $auth = \Auth::user();
        return get_class($this) == get_class($auth) && $this->id === $auth->id;
    }

    /**
     * Relation
     */
    public function cart()
    {
        return $this->belongsToMany('App\Model\Product', 'carts');
    }

    public function orders()
    {
        return $this->hasMany('App\Model\Order');
    }

    public function transactions()
    {
        return $this->hasMany('App\Model\Wallet');
    }

}
