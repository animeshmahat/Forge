<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class UserController extends BaseController
{
    protected $base_route = 'admin.users.index';
    protected $view_path = 'admin.users';
    protected $panel = 'User';
    protected $model;

    public function __construct()
    {
        $this->model = new User;
    }

    public function index()
    {
        $data['row'] = DB::table('users')->get();
        return view(parent::loadDefaultDataToView($this->view_path . '.index'), compact('data'));
    }

    public function create()
    {
        return view(parent::loadDefaultDataToView($this->view_path . '.create'));
    }
    public function store(Request $request)
    {
        $validator = $this->model->getRules($request->all());

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $model              = $this->model;
        $model->name        = $request->name;
        $model->email       = $request->email;
        $model->mobile      = $request->mobile;
        $model->username    = $request->username;
        $model->status      = $request->status ? true : false;
        $model->password    = $request->password;

        if ($request->hasFile('image')) {
            $image      = $request->file('image');
            $imageName  = time() . '.' . $image->getClientOriginalExtension();
            $image->move('public_path'('uploads/user_image'), $imageName);
        } else {
            $imageName = null;
        }
        $model->image = $imageName;
        $success = $model->save();

        if ($success) {
            $request->session()->flash('success', $this->panel . ' successfully added.');
            return redirect()->route($this->base_route);
        } else {
            return redirect()->route($this->base_route);
        }
    }

    public function edit(Request $request, $id)
    {
        $data = [];
        $data['row'] = $this->model->findorFail($id);
        return view(parent::loadDefaultDataToView($this->view_path . '.edit'), compact('data'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name'      => 'required|max:40|min:2',
            'username'  => ['string', 'max:255', "unique:users,username,{$id}"],
            'mobile'    => 'nullable|max:15|min:7|unique:users,mobile,{$id}',
            'status'    => 'boolean'
        ]);

        $data               = $this->model->findOrFail($id);

        $data->name         = $request->name;
        $data->mobile       = $request->mobile;
        $data->username     = $request->username;
        $data->status       = $request->status ? true : false;

        $success = $data->save();

        if ($success) {
            $request->session()->flash('update_success', $this->panel . ' successfully updated');
            return redirect()->route($this->base_route);
        } else {
            return redirect()->route($this->base_route);
        }
    }
    public function delete($id)
    {
        $model = $this->model;
        $data = $model::findOrFail($id);

        if ($data->image) {
            $image_path = public_path("uploads/user_image/{$data->image}");
            if (file_exists($image_path)) {
                unlink($image_path);
            }
        }

        $success = $data->delete();

        if ($success) {
            return redirect()->route($this->base_route)->with('delete_success', $this->panel . ' successfully deleted.');
        }
    }
}
