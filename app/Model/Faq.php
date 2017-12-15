<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Model\Extension\OrderableTrait;
use App\Model\Extension\PublishableTrait;

class Faq extends BaseModel
{
    use OrderableTrait, PublishableTrait;

    protected $table = 'faqs';

    protected $urlKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'order',
        'name', 
        'question',
        'answer',
        'published'
    ];

}
