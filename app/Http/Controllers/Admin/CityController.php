<?php

namespace App\Http\Controllers\Admin;

use App\Model\City as Model;
use App\Model\Province;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Yajra\Datatables\Datatables;

class CityController extends ResourceController
{

    /**
     * Form Rules
     * @var array
     */
    protected $rules = [
        'province_id' => 'required|integer|exists:provinces,id',
        'name' => 'required|string',
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
        parent::formRules();
    }

    public function formData()
    {
        parent::formData();
        $provinces = Province::pluck('name', 'id');
        view()->share([
            'provinces'=> ['' => '-'] + $provinces->toArray()
        ]);
    }

    protected function doSave() 
    {
        parent::doSave();
    }
    
}
