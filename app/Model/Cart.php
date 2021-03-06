<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Cart extends BaseModel
{
    protected $table = 'carts';

    protected $urlKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'product_id',
        'product_variant_id',
        'amount',
        'size'
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

    public function productVariant()
    {
        return $this->belongsTo('App\Model\ProductVariant');
    }

}
