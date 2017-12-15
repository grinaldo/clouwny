<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use App\Model\Extension\PublishableTrait;

class Page extends BaseModel
{
    use Sluggable, PublishableTrait;

    protected $table = 'pages';

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
        'slug',
        'url_prefix',
        'layout',
        'name', 
        'image',
        'title',
        'short_title',
        'short_description', 
        'description',
        'published'
    ];

}
