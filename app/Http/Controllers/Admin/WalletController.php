<?php

namespace App\Http\Controllers\Admin;

use App\Model\Wallet as Model;
use App\Model\User;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Yajra\Datatables\Datatables;

class WalletController extends ResourceController
{

    /**
     * Form Rules
     * @var array
     */
    protected $rules = [
        'user_id' => 'required|integer|exists:users,id',
        'type' => 'required|string',
        'amount' => 'required|numeric',
        'status' => 'required|string',
    ];

    /**
     * Column Edit
     * ['column_name', 'edit value']
     *
     * @var array
     */
    protected $columnEdit = [
        [
            'status',
            '{!! $status=="success"?"<span class=\"label label-success\">$status</span>":"<span class=\"label label-warning\">$status</span>" !!}'
        ]
    ];
    /**
     * Eloquent Eager Loading
     * @var array
     */
    protected $eagerLoad = [
        ['user', 'wallet_transactions.*']
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
        $users = User::pluck('name', 'id');
        view()->share([
            'types'    => Model::transactionTypes(),
            'statuses' => Model::transactionStatuses(),
            'users'    => ['' => '-'] + $users->toArray(),
        ]);
    }

    protected function doSave() 
    {
        parent::doSave();
    }

}
