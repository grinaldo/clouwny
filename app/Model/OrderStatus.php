<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class OrderStatus extends BaseModel
{
    protected $table = 'order_statuses';

    protected $urlKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'order_id',
        'status'
    ];

    public static function boot()
    {
        parent::boot();
    }

    /**
     * Relation
     */
    public function order()
    {
        return $this->belongsTo('App\Model\Order');
    }

}
