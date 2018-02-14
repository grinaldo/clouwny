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
    /**
      * Your variant association container
      */ 
    protected $variantData = [];

    public static function boot()
    {
        parent::boot();

        static::saved(function ($model) {
            $model->saveImageData();
            $model->saveVariantData();
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
        $imageSet->image       = $image['image'];
        $this->imageData[]     = $imageSet;
        return $imageSet;
    }

    /**
     * Associate nested inputs -> will be used in controller
     */
    public function setVariant($variant)
    {
        if ($this->exists) {
            $variantSet = $this->variants()->where('id', $variant['id'])->first();
        }
        if (empty($variantSet)) {
            $variantSet = $this->variants()->getRelated();
        }
        if (empty($variant['name'])) {
            return null;
        }
        $variantSet->name        = $variant['name'];
        $variantSet->stock       = $variant['stock'];
        $variantSet->description = $variant['description'];
        $this->variantData[]     = $variantSet;
        return $variantSet;
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
     * Called on saving process to associate variants
     */
    public function saveVariantData()
    {
        foreach ($this->variantData as $key => $variant) {
            $variant->product()->associate($this);
            $variant->save();
        }
    }

    /**
     * Relation
     */
    public function images()
    {
        return $this->hasMany('App\Model\ProductImage');
    }

    public function variants()
    {
        return $this->hasMany('App\Model\ProductVariant');
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
