<?php

namespace App\Providers;

use App\Models\Article;
use App\Models\Category;
use App\Models\Settings;
use App\Models\SocialMedia;
use Conner\Tagging\Model\Tag;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (app()->runningInConsole()) {
            return;
        }

        $socials = Schema::hasTable('social_media') ? SocialMedia::orderBy('id', 'DESC')->get() : collect();
        $categories = Schema::hasTable('categories') ? Category::where('isActive', 1)->orderBy('created_at', 'DESC')->get() : collect();
        $articles = Schema::hasTable('articles') ? Article::where('isActive', 1)->orderBy('created_at', 'DESC')->limit(5)->get() : collect();
        $tags = Schema::hasTable('tags') ? Tag::orderBy('id', 'DESC')->limit(15)->get() : collect();
        $settings = Schema::hasTable('settings') ? Settings::where('id', 1)->first() : null;
        $famous_articles = Schema::hasTable('articles') ? Article::where('isActive', 1)->orderBy('created_at', 'DESC')
            ->orderBy('views', 'DESC')
            ->limit(3)->get() : collect();

        view()->share('global_social', $socials);
        view()->share('global_category', $categories);
        view()->share('global_recent_articles', $articles);
        view()->share('global_tags', $tags);
        view()->share('global_settings', $settings);
        view()->share('global_famous_articles', $famous_articles);
    }
}
