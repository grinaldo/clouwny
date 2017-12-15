<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use App\Model\Extension\OrderableTrait;
use App\Model\Extension\PublishableTrait;

class Category extends BaseModel
{
    use Sluggable, OrderableTrait, PublishableTrait;

    protected $table = 'categories';

    protected $urlKey = 'slug';

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
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
        'order',
        'name', 
        'image',
        'short_description', 
        'description',
        'published'
    ];

    /**
     * Relation
     */
    public function products()
    {
        return $this->hasMany('App\Model\Product');
    }

}
