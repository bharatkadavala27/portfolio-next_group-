<?php
namespace App\Providers;

use App\Models\AboutSettings;
use App\Models\Brand;
use App\Models\Category;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;
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
    public function boot()
    {
        // Use Bootstrap for pagination
        Paginator::useBootstrap();

        // Fetch the first AboutSettings record and share it with all views
        $aboutSettings = AboutSettings::first();
        View::share('aboutSettings', $aboutSettings);

        // Share brands and categories with all views
        if (\Illuminate\Support\Facades\Schema::hasColumn('brands', 'show_on_footer')) {
            View::share('footerBrands', Brand::where('show_on_footer', 1)->orderBy('name', 'asc')->take(4)->get());
        } else {
            View::share('footerBrands', collect([]));
        }

        if (\Illuminate\Support\Facades\Schema::hasColumn('categories', 'show_on_footer')) {
            View::share('footerCategories', Category::where('show_on_footer', 1)->orderBy('name', 'asc')->take(4)->get());
        } else {
            View::share('footerCategories', collect([]));
        }

        // Share categories with 'navbar' view, fetching parent categories
        View::composer('partials.navbar', function ($view) {
            $categories = Category::with('parentCategory')->whereNull('parent_id')->get();
            $view->with('categories', $categories);
        });

        // If you need to share all categories with all views, this can be done
        // directly as we already shared a limited set of categories above.
        View::share('allCategories', Category::with('parentCategory')->whereNull('parent_id')->get());

        Livewire::component('products', \App\Http\Livewire\Products::class);
    }


}
