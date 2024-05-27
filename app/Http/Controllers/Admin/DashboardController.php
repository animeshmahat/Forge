<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

class DashboardController extends BaseController
{
    protected $base_route = "admin.index";
    protected $view_path = "admin.index";
    protected $panel = "Forge";
    public function index()
    {
        return view(parent::loadDefaultDataToView($this->base_route));
    }
}
