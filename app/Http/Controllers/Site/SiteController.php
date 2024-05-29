<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Admin\BaseController;
use App\Models\Category;
use App\Models\Comments;
use App\Models\Posts;
use App\Models\PostView;
use App\Models\Tags;
use Carbon\Carbon;
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

        // Increment the views count
        $post->increment('views');

        // Store the datetime of the view
        PostView::create([
            'post_id' => $post->id,
            'viewed_at' => now(),
        ]);

        $post_id = $post->id;
        $comments = Comments::where('post_id', $post_id)->get();

        // Categories with most posts
        $categories = Category::where('status', 1)->get();
        $categoriesWithMostPosts = Category::withCount(['posts' => function ($query) {
            $query->where('status', 1);
        }])->where('status', 1)->orderBy('posts_count', 'DESC')->get();

        // Get tags with most posts
        $tagsWithMostPosts = Tags::withCount(['posts' => function ($query) {
            $query->where('status', 1);
        }])->orderBy('posts_count', 'DESC')->get();

        $popularPosts = Posts::where('status', 1)->orderBy('views', 'DESC')->take(7)->get();

        // Get trending posts based on views and comments
        $trendingPosts = Posts::where('status', 1)
            ->select('posts.*')
            ->selectRaw('(views + (SELECT COUNT(*) FROM comments WHERE comments.post_id = posts.id)) as popularity_score')
            ->leftJoin('post_views', function ($join) {
                $join->on('posts.id', '=', 'post_views.post_id')
                    ->where('post_views.viewed_at', '>=', Carbon::now()->subHours(48));
            })
            ->orderByDesc('popularity_score')
            ->distinct()
            ->take(7)
            ->get();

        $latest = Posts::where('status', 1)->orderBy('created_at', 'DESC')->take(7)->get();

        $data = [
            'post' => $post,
            'post_id' => $post_id,
            'comments' => $comments,
            'categoriesWithMostPosts' => $categoriesWithMostPosts,
            'tagsWithMostPosts' => $tagsWithMostPosts,
            'popularPosts' => $popularPosts,
            'trendingPosts' => $trendingPosts,
            'latest' => $latest,
        ];
        return view(parent::loadDefaultDataToView($this->view_path . '.single-post'), compact('data'));
    }
}
