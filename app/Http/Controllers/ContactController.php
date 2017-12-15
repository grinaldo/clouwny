<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Contact;

class ContactController extends Controller
{
    public function index()
    {
        return view('contacts.index');
    }

    public function store(Request $request)
    {
        $rules     = [
            'name'    => 'required|string',
            'email'   => 'sometimes|nullable|email|string',
            'phone'   => 'required|string',
            'content' => 'required|string'
        ];
        $validator = \Validator::make($request->all(), $rules);
        if (!$validator->passes()) {
            session()->flash(NOTIF_DANGER, 'Please input data correctly!');
            return redirect()->back()->withInput($request->all());
        }
        $contact   = new Contact($request->all());
        $contact->save();
        session()->flash(NOTIF_SUCCESS, 'Inquiry successfully submitted!');

        return redirect()->route('home');
    }
    
}
