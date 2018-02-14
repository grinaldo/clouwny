<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ProductVariant extends BaseModel
{
    // Is actually product variant
    protected $table = 'product_variants';

    protected $urlKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'product_id',
        'name', 
        'image',
        'stock',
        'description'
    ];

    /**
     * Relation
     */
    public function product()
    {
        return $this->belongsTo('App\Model\Product');
    }

    public function productVariant()
    {
        return $this->hasMany('App\Model\ProductVariant');
    }

}
