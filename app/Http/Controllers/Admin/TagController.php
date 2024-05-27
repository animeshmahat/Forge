<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tags;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TagController extends BaseController
{
    protected $base_route = 'admin.tags.index';
    protected $view_path = 'admin.tags';
    protected $panel = 'Tags';
    protected $model;

    public function __construct()
    {
        $this->model = new Tags;
    }
    public function index()
    {
        $data['row'] = DB::table('tags')->get();
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

        $success            = $model->save();

        if ($success) {
            $request->session()->flash('success', $this->panel . ' successfully added.');
            return redirect()->route($this->base_route);
        } else {
            return redirect()->route($this->base_route);
        }
    }
    public function edit($id)
    {
        $data = [];
        $data['row'] = $this->model->findOrFail($id);
        return view(parent::loadDefaultDataToView($this->view_path . '.edit'), compact('data'));
    }
    public function update(Request $request, $id)
    {
        $validator = $this->model->getRules($request->all());
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data = $this->model::findorFail($id);

        $data->name           = $request->name;

        $success = $data->save();

        if ($success) {
            $request->session()->flash('update_success', $this->panel . ' successfully updated.');
            return redirect()->route($this->base_route);
        } else {
            return redirect()->route($this->base_route);
        }
    }
    public function delete($id)
    {
        $model = $this->model;
        $data = $model::findOrFail($id);
        $success = $data->delete();

        if ($success) {
            return redirect()->route($this->base_route)->with('delete_success', $this->panel . ' deleted successfully.');
        }
    }
}
