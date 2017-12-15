<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Model\Extension\PublishableTrait;

class SocialMedia extends BaseModel
{
    use PublishableTrait;

    protected $table = 'social_medias';

    protected $urlKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'image',
        'name', 
        'url', 
        'description',
        'published'
    ];

}
