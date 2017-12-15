<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Contact extends BaseModel
{
    protected $table = 'contacts';

    protected $urlKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 
        'phone',
        'email',
        'content'
    ];

}
