l<?php

namespace App\Http\Controllers\Admin;

// use App\Http\Form\Admin\ChangePasswordForm as Form;
use App\Supports\BackendSessionProcess;
use App\Http\Controllers\Controller;

class SessionController extends Controller
{
    public function __construct()
    {
        // parent::__construct();

        // $this->form = $form;
        // $this->session = $session;
    }

    public function login()
    {
        if (request()->isMethod('get')) {
            return view()->make(suitViewName('login'));
        }
        if (request()->isMethod('post')) {
            if (!$this->session->login()) {
                return redirect()->route(suitRouteName('login'));
            }

            return redirect()->route(suitRouteName('index'));
        }
        app()->abort(404);
    }

    public function logout()
    {
        $this->session->logout();
        return redirect()->to(suitLogoutUrl());
    }

    public function changePassword()
    {
        if (request()->isMethod('get')) {
            return view()->make(suitViewName('password.change'));
        } elseif (request()->isMethod('post')) {
            if (!$this->form->validate()) {
                session()->flashInput($this->form->input());
                session()->flash('error', $this->form->errors());
                return redirect()->route(suitRouteName('password'))
                                ->with(NOTIF_DANGER, suitTrans('resources.invalid_field'));
            }
            $user = auth()->user();
            $user->password = $this->form->get('new_password');
            $user->save();
            auth()->setUser($user);
            return redirect()->route(suitRouteName('index'))
                            ->with(NOTIF_SUCCESS, suitTrans('messages.password_success'));
        }
    }
}
