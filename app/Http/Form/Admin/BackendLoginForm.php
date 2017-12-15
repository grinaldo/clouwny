<?php
namespace App\Http\Form\Admin;

class BackendLoginForm extends Form
{

    protected function rules()
    {
        return [
            'username' => 'required',
            'password' => 'required',
            'captcha' => 'required|captcha',
        ];
    }

    public function getCredential()
    {
        return $this->request->only(['username', 'password']);
    }
}
