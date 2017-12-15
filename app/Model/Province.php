<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Province extends BaseModel
{
    use Sluggable;

    protected $table = 'provinces';

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
    ];

    /**
      * Your image association container
      */ 
    protected $imageData = [];

    public static function boot()
    {
        parent::boot();
    }

    /**
     * Relation
     */
    public function cities()
    {
        return $this->hasMany('App\Model\City');
    }
    
}
