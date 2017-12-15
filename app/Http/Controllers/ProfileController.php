<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\User;

class ProfileController extends Controller
{
    public function index() 
    {
        if (\Auth::check()) {
            return view('profiles.index', [
                'profileNav' => 'profile'
            ]);
        } else {
            return redirect()->route('home');
        }
    }

    public function edit()
    {
        if (\Auth::user()) {
            $model = User::find(\Auth::user()->id);
            if (empty($model)) {
                session()->flash(NOTIF_DANGER, 'User data error!');
                return redirect()->route('home');
            }
            return view('profiles.edit', ['model' => $model]);
        } else {
            return redirect()->route('home');
        }
    }

    public function update(Request $request)
    {
        $rules = [
            'username' => 'required|alpha_dash|unique:users,username,'.\Auth::user()->id,
            'email' => 'required|email|unique:users,email,'.\Auth::user()->id,
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
        $model = User::where('username', '=', $request->username)->first();
        if (empty($model->username) || \Auth::user()->username !== $model->username) {
            session()->flash(NOTIF_DANGER, 'Update not allowed!');
            return redirect()->back();
        }
        $validator = \Validator::make($request->all(), $rules);
        if (!$validator->passes()) {
            session()->flash(NOTIF_DANGER, 'Please correct the '. key($validator->errors()->messages()) . ' input');
            return redirect()->back();
        }
        $model->fill($request->all());
        $model->save();
        session()->flash(NOTIF_SUCCESS, 'Profile updated!');
        return redirect()->route('profile');
    }
}
