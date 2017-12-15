<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Wallet extends BaseModel
{
    protected $table = 'wallet_transactions';

    protected $urlKey = 'id';

    const TRANSACTION_WITHDRAWAL         = 'withdrawal';
    const TRANSACTION_TOPUP              = 'top-up';
    const TRANSACTION_REFUND             = 'refund';

    const TRANSACTION_STATUS_SUCCESS     = 'success';
    const TRANSACTION_STATUS_FAIL        = 'failed';
    const TRANSACTION_STATUS_CANCEL      = 'cancelled';
    const TRANSACTION_STATUS_REJECT      = 'rejected';
    const TRANSACTION_STATUS_ON_PROCESS  = 'on-process';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'type', 
        'amount',
        'status',
    ];

    public static function transactionTypes()
    {
        return [
            static::TRANSACTION_WITHDRAWAL => 'Withdrawal',
            static::TRANSACTION_REFUND     => 'Refund',
            static::TRANSACTION_TOPUP      => 'Top Up',
        ];
    }

    public static function transactionStatuses()
    {
        return [
            static::TRANSACTION_STATUS_ON_PROCESS => 'On Process',
            static::TRANSACTION_STATUS_SUCCESS    => 'Success',
            static::TRANSACTION_STATUS_FAIL       => 'Failed',
            static::TRANSACTION_STATUS_CANCEL     => 'Cancelled',
            static::TRANSACTION_STATUS_REJECT     => 'Rejected',
        ];
    }

    /**
     * Relation
     */
    public function user()
    {
        return $this->belongsTo('App\Model\User');
    }

}
