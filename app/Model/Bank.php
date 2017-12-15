<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Bank extends BaseModel
{
    protected $table = 'banks';

    protected $urlKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'image',
        'bank_name',
        'account_name',
        'account_number',
        'description'
    ];

    public static function boot()
    {
        parent::boot();
    }

}
