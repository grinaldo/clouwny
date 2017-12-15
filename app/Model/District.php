<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class District extends BaseModel
{
    use Sluggable;

    protected $table = 'districts';

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
        'city_id',
        'name',
        'code',
    ];

    /**
     * Relation
     */
    public function city()
    {
        return $this->belongsTo('App\Model\City');
    }

}
