<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\User;
use Carbon\Carbon;

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
            $provinces = \Cache::remember('profile-provinces', $this->cacheLong, function () {
                return \App\Model\Province::orderBy('name', 'ASC')->pluck('name', 'name');
            });
            $cities = \Cache::remember('profile-cities', $this->cacheLong, function () {
                return \App\Model\City::orderBy('name', 'ASC')->pluck('name', 'name');
            });
            $districts = \Cache::remember('profile-districts', $this->cacheLong, function () {
                return \App\Model\District::orderBy('name', 'ASC')->pluck('name', 'name');
            });
            return view('profiles.edit', [
                'model' => $model,
                'provinces' => $provinces,
                'cities' => $cities,
                'districts' => $districts,
            ]);
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
            'password_confirmation' => 'sometimes|nullable|basic_password|string|same:password',
            'gender' => 'sometimes|nullable|string',
            'phone' => 'sometimes|nullable|string',
            'birthday' => 'sometimes|nullable|string',
            'province' => 'sometimes|nullable|string',
            'city' => 'sometimes|nullable|string',
            'district' => 'sometimes|nullable|string',
            'zipcode' => 'sometimes|nullable|string',
            'address' => 'sometimes|nullable|string',
            'confirmation_account' => 'sometimes|nullable|string',
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
        $model->fill($request->except(['password', 'password_confirmation']));
        if (!empty($request->password)) {
            $model->password = \Hash::make($request->password);
        }
        if (!empty($request->birthday)) {
            $birthday = Carbon::createFromFormat('m/d/Y', $request->birthday);
            $model->birthday = $birthday;
        }
        $model->save();
        session()->flash(NOTIF_SUCCESS, 'Profile updated!');
        return redirect()->route('profile');
    }
}
