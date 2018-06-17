<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use App\Model\Extension\PublishableTrait;

class PromoCode extends BaseModel
{
    use PublishableTrait, Sluggable;

    protected $table = 'promo_codes';

    protected $urlKey = 'id';

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 
        'description',
        'limit',
        'discount',
        'published',
    ];
    
}
