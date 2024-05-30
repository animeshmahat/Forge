<?php

namespace App\Providers;

use App\Models\Posts;
use App\Services\PostService;
use Illuminate\Support\ServiceProvider;
use Session;
use Illuminate\Http\Request;
use View;
use Illuminate\Support\Facades\DB;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(PostService::class, function ($app) {
            return new PostService();
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $all_view['category'] = DB::table('categories')->where('status', 1)->get();
        $all_view['tags'] = DB::table('tags')->get();
        $all_view['setting'] = DB::table('settings')->first();
        $all_view['recent_posts'] = Posts::where('status', 1)->orderBy('created_at', 'DESC')->take(4)->get();
        View::share(compact('all_view'));
    }
}
