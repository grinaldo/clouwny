<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use App\Model\Extension\FeaturableTrait;
use App\Model\Extension\OrderableTrait;
use App\Model\Extension\PublishableTrait;

class Product extends BaseModel
{
    use Sluggable, FeaturableTrait, OrderableTrait, PublishableTrait;

    protected $table = 'products';

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
        'category_id',
        'name', 
        'image',
        'stock',
        'weight',
        'short_description', 
        'description',
        'discounted_price',
        'price',
        'actual_price',
        'is_sale',
        'is_featured',
        'published'
    ];

    /**
      * Your image association container
      */ 
    protected $imageData = [];

    public static function boot()
    {
        parent::boot();

        static::saved(function ($model) {
            $model->saveImageData();
        });
    }

    /**
     * Mutators
     */
    public function getIsSaleAttribute($value)
    {
        return ($value) ? 'sale' : 'not sale';
    }

    /**
     * Associate nested inputs -> will be used in controller
     */
    public function setImage($image)
    {
        if ($this->exists) {
            $imageSet = $this->images()->where('id', $image['id'])->first();
        }
        if (empty($imageSet)) {
            $imageSet = $this->images()->getRelated();
        }
        if (empty($image['name']) || empty($image['image'])) {
            return null;
        }
        $imageSet->name        = $image['name'];
        $imageSet->image       = $image['image'];
        $imageSet->stock       = $image['stock'];
        $imageSet->description = $image['description'];
        $this->imageData[]     = $imageSet;
        return $imageSet;
    }

    /**
     * Called on saving process to associate images
     */
    public function saveImageData()
    {
        foreach ($this->imageData as $key => $image) {
            $image->product()->associate($this);
            $image->save();
        }
    }

    /**
     * Relation
     */
    public function images()
    {
        return $this->hasMany('App\Model\ProductImage');
    }

    public function category()
    {
        return $this->belongsTo('App\Model\Category');
    }

    public function user()
    {
        return $this->belongsToMany('App\Model\User', 'carts');
    }

    public function orderItem()
    {
        return $this->belongsToMany('App\Model\Order', 'order_items');
    }
}
