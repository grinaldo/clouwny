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
        'discounted_price' => 'sometimes|nullable|min:0',
        'price' => 'required|min:0',
        'actual_price' => 'required|min:0',
        'is_sale' => '',
        'is_featured' => '',
        'published' => '',
        'product_images' => 'array',
        'product_images.*.id' => '',
        'product_images.*.image' => 'required',
        'product_variants' => 'array',
        'product_variants.*.id' => '',
        'product_variants.*.name' => 'required',
        'product_variants.*.stock' => 'required',
        'product_variants.*.description' => ''
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
        // Saving Product Images
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

        // Saving Product Variant
        $variantIds = [];
        $productVariants = $this->model->variants;
        if ($this->form->has('product_variants')) {
            $formVariants = $this->form->all()['product_variants'];
            foreach ($formVariants as $key => $variant) {
                $variantSet = $this->model->setVariant($variant);
                if (!is_null($variantSet) && !empty($variantSet->getKey())) {
                    $variantIds[] = $variantSet->getKey();
                }
            }
        }

        $this->model->stock = 0;
        $variants = $this->form->get('product_variants');
        if (!empty($variants)) {
            foreach ($variants as $variant) {
                $this->model->stock += $variant['stock'];
            }
        }
        if ($this->model->discounted_price) {
            $this->model->is_sale = true;
        }
        parent::doSave();

        // Mapping association
        $productImages->map(function ($image) use ($imageIds) {
            if (!in_array($image->getKey(), $imageIds)) {
                $image->delete();
            }
        });
        // Mapping association
        $productVariants->map(function ($variant) use ($variantIds) {
            if (!in_array($variant->getKey(), $variantIds)) {
                $variant->delete();
            }
        });
    }
    
}
