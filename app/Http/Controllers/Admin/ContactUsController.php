<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactUs;
use Illuminate\Http\Request;

class ContactUsController extends Controller
{
    protected $model;

    public function __construct()
    {
        $this->model = new ContactUs;
    }
    public function store(Request $request)
    {
        $validator = $this->model->getRules($request->all());

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $model                    = $this->model;
        $model->name              = $request->name;
        $model->email             = $request->email;
        $model->subject           = $request->subject;
        $model->message           = $request->message;

        $success                  = $model->save();


        if ($success) {
            $request->session()->flash('success', 'Your message has been sent. Thank you!');
            return redirect()->back();
        } else {
            return redirect()->back();
        }
    }
}
