<?php

namespace App\Http\Controllers\Admin;

use App\Model\Product as Model;
use App\Model\Category;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Yajra\Datatables\Datatables;

class ProductController extends ResourceController
{

    /**
     * Form Rules
     * @var array
     */
    protected $rules = [
        'slug' => 'alpha_dash|unique:products,slug',
        'category_id' => 'required|integer|exists:categories,id',
        'name' => 'required|string|unique:products,name',
        'order' => 'integer',
        // 'stock' => 'integer',
        'weight' => 'integer',
        'image' => 'required|string',
        'short_description' => 'sometimes|nullable|string',
        'description' => 'sometimes|nullable|string',
        'discounted_price' => 'min:0',
        'price' => 'min:0',
        'actual_price' => 'min:0',
        'is_sale' => '',
        'is_featured' => '',
        'published' => '',
        'product_images' => 'array',
        'product_images.*.id' => '',
        'product_images.*.name' => 'required',
        'product_images.*.image' => 'required',
        'product_images.*.stock' => 'required',
        'product_images.*.description' => ''
    ];
    /**
     * Eloquent Eager Loading
     * @var array
     */
    protected $eagerLoad = [
        ['category', 'products.*'],
    ];

    public function __construct(Model $model)
    {
        parent::__construct($model);
    }

    protected function beforeValidate()
    {
        parent::beforeValidate();
        // Put your form requirement here
        // e.g. $this->form->setModelId($this->model->getKey());
    }

    protected function formRules()
    {
        if ($this->model->exists) {
            foreach(['slug','name'] as $key) {
                $this->rules[$key] .= ','.$this->model->getKey();
            }
        } else {
            $this->rules['slug'] = 'sometimes|nullable|'.$this->rules['slug'];
        }
        parent::formRules();
    }

    public function formData()
    {
        parent::formData();
        $categories = Category::pluck('name', 'id');
        view()->share([
            'categories'=> ['' => '-'] + $categories->toArray()
        ]);
    }

    protected function doSave() 
    {
        $imageIds = [];
        $productImages = $this->model->images;
        if ($this->form->has('product_images')) {
            $formImages = $this->form->all()['product_images'];
            foreach ($formImages as $key => $image) {
                $imageSet = $this->model->setImage($image);
                if (!is_null($imageSet) && !empty($imageSet->getKey())) {
                    $imageIds[] = $imageSet->getKey();
                }
            }
        }
        $this->model->stock = 0;
        $variants = $this->form->get('product_images');
        foreach ($variants as $variant) {
            $this->model->stock += $variant['stock'];
        }
        parent::doSave();

        // Mapping association
        $productImages->map(function ($image) use ($imageIds) {
            if (!in_array($image->getKey(), $imageIds)) {
                $image->delete();
            }
        });
    }
    
}
