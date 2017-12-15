<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class City extends BaseModel
{
    use Sluggable;
    
    protected $table = 'cities';

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
        'province_id',
        'name',
    ];

    /**
     * Relation
     */
    public function province()
    {
        return $this->belongsTo('App\Model\Province');
    }

    public function districts()
    {
        return $this->hasMany('App\Model\District');
    }

}
