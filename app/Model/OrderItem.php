<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends BaseModel
{
    protected $table = 'order_items';

    protected $urlKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'order_id',
        'product_id',
        'product_variant_id',
        'amount',
        'sold_price'
    ];

    public static function boot()
    {
        parent::boot();
    }

    /**
     * Relation
     */
    public function orders()
    {
        return $this->hasMany('App\Model\Order');
    }

    public function product()
    {
        return $this->belongsTo('App\Model\Product');
    }

}
