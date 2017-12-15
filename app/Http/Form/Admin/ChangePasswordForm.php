<?php
namespace App\Http\Form\Admin;

class ChangePasswordForm extends Form
{
    public function rules()
    {
        return [
            'current_password' => 'required|current_password:Auth',
            'new_password' => 'required|confirmed|min:8',
            'new_password_confirmation' => 'required'
        ];
    }

    public function getNewPassword()
    {
        return $this->request->input('new_password');
    }
}
