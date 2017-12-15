<?php

namespace App\Http\Controllers\Admin;

use App\Model\Contact as Model;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Yajra\Datatables\Datatables;

class ContactController extends ResourceController
{

    /**
     * Form Rules
     * @var array
     */
    protected $rules = [
        'name' => 'required|string',
        'phone' => 'required|string',
        'email' => 'sometimes|nullable|string',
        'content' => 'required|string',
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
