<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Admin\BaseController;
use App\Models\Posts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SiteController extends BaseController
{
    protected $base_route = "site";
    protected $view_path  = "site";
    protected $panel = "Forge";
    protected $model;
    public function __construct()
    {
    }
    public function index(Request $request)
    {
        $post = Posts::where('status', 1)->orderBy('created_at', 'DESC')->get();
        // Select a random post
        $random = Posts::where('status', 1)->inRandomOrder()->first();

        // Select one post per category
        $postbycategory = Posts::select('category_id', DB::raw('MAX(id) as id'))
            ->where('status', 1)
            ->groupBy('category_id')
            ->orderByRaw('RAND()')
            ->get();

        // Fetch the actual post data using the selected IDs
        $postbycategory = Posts::whereIn('id', $postbycategory->pluck('id'))->get();
        $postbycategory2 = Posts::whereNotIn('id', $postbycategory->pluck('id'))
            ->where('status', 1)
            ->orderBy('created_at', 'DESC')
            ->get();

        $trending = Posts::where('status', 1)->orderBy('views', 'DESC')->get();
        $data = [
            'post' => $post,
            'random' => $random,
            'postbycategory' => $postbycategory,
            'trending' => $trending,
            'postbycategory2' => $postbycategory2,
        ];
        return view(parent::loadDefaultDataToView($this->view_path . '.index'), compact('data'));
    }
    public function single_post(Request $request, $slug)
    {
        $post = Posts::where('slug', $slug)->firstOrFail();
        $post->increment('views');

        $data = [
            'post' => $post,
        ];
        return view(parent::loadDefaultDataToView($this->view_path . '.single-post'), compact('data'));
    }
}
