<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Wishlist extends BaseModel
{
    protected $table = 'wishlists';

    protected $urlKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'product_id'
    ];

    public static function boot()
    {
        parent::boot();
    }

    /**
     * Relation
     */
    public function products()
    {
        return $this->hasMany('App\Model\Product');
    }

    public function users()
    {
        return $this->hasMany('App\Model\User');
    }

    public function product()
    {
        return $this->belongsTo('App\Model\Product');
    }

}
