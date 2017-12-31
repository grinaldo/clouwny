<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Order extends BaseModel
{
    protected $table = 'orders';

    protected $urlKey = 'id';

    const ORDER_STATUS_AWAITING_PAYMENT      = 'Awaiting Payment';
    const ORDER_STATUS_AWAITING_VERIFICATION = 'Awaiting Order Verification';
    const ORDER_STATUS_VERIFIED              = 'Order Verified';
    const ORDER_STATUS_SHIPPED               = 'Order Shipped';
    const ORDER_STATUS_CANCELLED             = 'Order Cancelled';
    const ORDER_STATUS_REFUNDED              = 'Order Refund';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'order_number',
        'tracking_number',
        'latest_status',
        'is_dropship',
        'shipping_fee',
        'total_fee',
        'shipper_name',
        'shipper_email',
        'shipper_phone',
        'shipper_province',
        'shipper_city',
        'shipper_district',
        'shipper_zipcode',
        'shipper_address',
        'receiver_name',
        'receiver_email',
        'receiver_phone',
        'receiver_province',
        'receiver_city',
        'receiver_district',
        'receiver_zipcode',
        'receiver_address',
        'payment_method',
        'delivery_company',
        'delivery_type',
        'confirmation_channel',
        'confirmation_account',
        'confirmation_transfer',
        'confirmation_transfer_date',
        'confirmation_transfer_amount',
        'confirmation_payer',
    ];

    public static function boot()
    {
        parent::boot();
    }

    public function setIsDropshipAttribute($value)
    {
        if (!empty($value) && $value == 'on') {
            $this->attributes['is_dropship'] = true;
        }
    }

    /**
     * Relation
     */
    public function user()
    {
        return $this->belongsTo('App\Model\User');
    }

    public function orderItems()
    {
        return $this->hasMany('\App\Model\OrderItem');
    }

    public function products()
    {
        return $this->belongsToMany('App\Model\Product', 'order_items');
    }

    public function statuses()
    {
        return $this->hasMany('App\Model\OrderStatus');
    }

    public static function orderStatuses()
    {
        return [
            static::ORDER_STATUS_AWAITING_PAYMENT       => 'Awaiting Payment',
            static::ORDER_STATUS_AWAITING_VERIFICATION  => 'Awaiting Verification',
            static::ORDER_STATUS_VERIFIED               => 'Verified',
            static::ORDER_STATUS_SHIPPED                => 'Shipped',
            static::ORDER_STATUS_CANCELLED              => 'Cancelled',
            static::ORDER_STATUS_REFUNDED               => 'Refunded',
        ];
    }

}
