<?php

namespace App\Http\Controllers\Blogger;

use App\Http\Controllers\Admin\BaseController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends BaseController
{

    protected $base_route = "blogger.index";
    protected $view_path = "blogger.index";
    protected $panel = "Forge";
    public function index()
    {
        return view(parent::loadDefaultDataToView($this->base_route));
    }
}
