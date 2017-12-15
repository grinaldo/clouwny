<?php

namespace App\Http\Controllers\Admin;

use App\Model\District as Model;
use App\Model\City;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Yajra\Datatables\Datatables;

class DistrictController extends ResourceController
{

    /**
     * Form Rules
     * @var array
     */
    protected $rules = [
        'city_id' => 'required|integer|exists:cities,id',
        'name' => 'required|string',
        'code' => 'sometimes|string',
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
        $cities = City::pluck('name', 'id');
        view()->share([
            'cities'=> ['' => '-'] + $cities->toArray()
        ]);
    }

    protected function doSave() 
    {
        parent::doSave();
    }
    
}
