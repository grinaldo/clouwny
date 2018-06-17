<?php

namespace App\Http\Controllers\Admin;

use App\Model\PromoCode as Model;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Yajra\Datatables\Datatables;

class PromoCodeController extends ResourceController
{

    /**
     * Form Rules
     * @var array
     */
    protected $rules = [
        'name' => 'required|string',
        'description' => 'sometimes|nullable|string',
        'limit' => 'required|integer',
        'discount' => 'required|integer|min:0|max:100',
        'published' => '',
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
    }

    protected function doSave() 
    {
        parent::doSave();
    }

}
