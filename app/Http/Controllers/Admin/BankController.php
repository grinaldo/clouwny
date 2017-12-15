<?php

namespace App\Http\Controllers\Admin;

use App\Model\Bank as Model;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Yajra\Datatables\Datatables;

class BankController extends ResourceController
{

    /**
     * Form Rules
     * @var array
     */
    protected $rules = [
        'bank_name'      => 'required|string',
        'account_name'   => 'required|string',
        'account_number' => 'required|string|unique:banks',
        'description'    => 'sometimes|nullable|string',
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
