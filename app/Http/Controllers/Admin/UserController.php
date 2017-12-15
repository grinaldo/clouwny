<?php

namespace App\Http\Controllers\Admin;

use App\Model\User as Model;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Yajra\Datatables\Datatables;

class UserController extends ResourceController
{

    /**
     * Form Rules
     * @var array
     */
    protected $rules = [
        // 'slug' => 'alpha_dash|unique:contents,slug',
        'role' => 'required|integer',
        'username' => 'required|alpha_dash|unique:users,username',
        'email' => 'required|email|unique:users,email',
        'name' => 'required|string',
        'password' => 'sometimes|nullable|basic_password|confirmed',
        'password_confirmation' => 'sometimes|nullable|string',
        'gender' => 'sometimes|nullable|string',
        'phone' => 'sometimes|nullable|string',
        'birthday' => 'sometimes|nullable|string',
        'province' => 'sometimes|nullable|string',
        'city' => 'sometimes|nullable|string',
        'district' => 'sometimes|nullable|string',
        'zipcode' => 'sometimes|nullable|string',
        'address' => 'sometimes|nullable|string',
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
        // if ($this->model->exists) {
        //     foreach (['slug'] as $key) {
        //         $this->rules[$key] .= ','.$this->model->getKey();
        //     }
        // }
        $this->rules['role'] .= '|in:' . $this->implode(array_keys(Model::groups()));
        if ($this->model->exists) {
            foreach (['username', 'email'] as $key) {
                $this->rules[$key] .= ','.$this->model->getKey();
            }
        } else {
            foreach (['password', 'password_confirmation'] as $key) {
                $this->rules[$key] .= '|required';
            }
        }
        parent::formRules();
    }

    public function formData()
    {
        parent::formData();
        view()->share([
            'roles' => Model::groups()
        ]);
    }

    protected function doSave() 
    {
        if(\Auth::user()->role !== Model::ROLE_SUPER_ADMIN && 
            $this->form->input('role') == MODEL::ROLE_SUPER_ADMIN) {
            session()->flash(NOTIF_DANGER, 'Role unchanged! You are not allowed to do that!');
            return redirect()->back();
        }
        parent::doSave();
    }
    
}
