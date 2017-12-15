<?php

namespace App\Http\Controllers\Admin;

use App\Model\Page as Model;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Yajra\Datatables\Datatables;

class PageController extends ResourceController
{

    /**
     * Form Rules
     * @var array
     */
    protected $rules = [
        'slug' => 'alpha_dash|unique:pages,slug',
        'url_prefix' => 'sometimes|nullable|string',
        'layout' => 'sometimes|nullable|string',
        'name' => 'required|string|unique:pages,name',
        'title' => 'required|string',
        'short_title' => 'sometimes|nullable|string',
        'short_description' => 'sometimes|nullable|string',
        'description' => 'sometimes|nullable|string',
        'published' => ''
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
    }

    protected function doSave() 
    {
        parent::doSave();
    }
    
}
