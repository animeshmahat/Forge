<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Admin\BaseController;
use App\Models\Category;
use App\Models\Comments;
use App\Models\Posts;
use App\Models\PostView;
use App\Models\Tags;
use App\Services\PostService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Str;

class SiteController extends BaseController
{
    protected $base_route = "site";
    protected $view_path  = "site";
    protected $panel = "Forge";
    protected $model;
    protected $postService;
    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
    }
    public function index(Request $request)
    {
        $post = Posts::where('status', 1)->orderBy('created_at', 'DESC')->take(5)->get();
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

        $trending = $this->postService->getTrendingPosts();

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

        // Sidebar data (same as category page)
        $categories = Category::where('status', 1)->get();
        $categoriesWithMostPosts = Category::withCount(['posts' => function ($query) {
            $query->where('status', 1);
        }])->where('status', 1)->orderBy('posts_count', 'DESC')->get();
        $tagsWithMostPosts = Tags::withCount(['posts' => function ($query) {
            $query->where('status', 1);
        }])->orderBy('posts_count', 'DESC')->get();
        $popularPosts = Posts::where('status', 1)->orderBy('views', 'DESC')->take(7)->get();
        $trendingPosts = $this->postService->getTrendingPosts();
        $latest = Posts::where('status', 1)->orderBy('created_at', 'DESC')->take(7)->get();

        $summaries = $this->postService->summarizeText($post->title, $post->description);

        // Calculate reading time (words per minute)
        $wordCount = str_word_count(strip_tags($post->description));
        $readingTime = ceil($wordCount / 238); // Assuming 200 words per minute

        $data = [
            'post' => $post,
            'post_id' => $post_id,
            'comments' => $comments,
            'categoriesWithMostPosts' => $categoriesWithMostPosts,
            'tagsWithMostPosts' => $tagsWithMostPosts,
            'popularPosts' => $popularPosts,
            'trendingPosts' => $trendingPosts,
            'latest' => $latest,
            'paragraph_summary' => $summaries['paragraph'] ?? '',
            'bullet_point_summary' => $summaries['bullet_points'] ?? [],
            'readingTime' => $readingTime, // Pass reading time to the view
        ];

        // Debugging: Log the data to ensure it's correct
        \Log::info($data);

        return view(parent::loadDefaultDataToView($this->view_path . '.single-post'), compact('data'));
    }
    public function category(Request $request, $name)
    {
        $category = Category::where('name', $name)->firstOrFail();
        $category_id = $category->id;
        $post = Posts::where('category_id', $category_id)->where('status', 1)->paginate('10');
        Paginator::useBootstrap();

        // Sidebar data (same as category page)
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
        $trendingPosts = $this->postService->getTrendingPosts();
        $latest = Posts::where('status', 1)->orderBy('created_at', 'DESC')->take(7)->get();

        $data = [
            'category' => $category,
            'category_id' => $category_id,
            'post' => $post,
            'categoriesWithMostPosts' => $categoriesWithMostPosts,
            'tagsWithMostPosts' => $tagsWithMostPosts,
            'popularPosts' => $popularPosts,
            'trendingPosts' => $trendingPosts,
            'latest' => $latest,
        ];

        return view(parent::loadDefaultDataToView($this->view_path . '.category'), compact('data'));
    }
    public function contact_us()
    {
        return view('site.contact-us');
    }
    public function about_us()
    {
        return view('site.about-us');
    }
    public function search(Request $request)
    {
        $search = $request->input('search');

        $results = Posts::where('title', 'like', "%$search%")
            ->orWhereHas('category', function ($query) use ($search) {
                $query->where('name', 'like', "%$search%");
            })
            ->orWhereHas('tags', function ($query) use ($search) {
                $query->where('name', 'like', "%$search%");
            })
            ->where('status', 1)
            ->orderBy('views', 'DESC')
            ->paginate('10');
        Paginator::useBootstrap();


        // Sidebar data (same as category page)
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
        $trendingPosts = $this->postService->getTrendingPosts();
        $latest = Posts::where('status', 1)->orderBy('created_at', 'DESC')->take(7)->get();

        $data = [
            'categoriesWithMostPosts' => $categoriesWithMostPosts,
            'tagsWithMostPosts' => $tagsWithMostPosts,
            'popularPosts' => $popularPosts,
            'trendingPosts' => $trendingPosts,
            'latest' => $latest,
        ];
        return view(parent::loadDefaultDataToView($this->view_path . '.search'), compact('data'), ['results' => $results, 'search' => $search,]);
    }
    public function autocomplete(Request $request)
    {
        $search = $request->input('search');
        $suggestions = Posts::where('title', 'like', "%$search%")
            ->where('status', 1)
            ->orderByRaw("CASE 
                            WHEN title LIKE ? THEN 1
                            ELSE 2
                          END, title", ["$search%"])
            ->limit(5) // Limit the number of suggestions to 5
            ->get(['title', 'slug']); // Retrieve both title and slug

        return response()->json($suggestions);
    }
}
