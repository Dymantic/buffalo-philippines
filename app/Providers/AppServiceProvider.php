<?php

namespace App\Providers;

use App\Observers\CategoryObserver;
use App\Observers\SubcategoryObserver;
use App\Products\Category;
use App\Products\Subcategory;
use App\Secretary;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {


        Blade::directive('activeclass', function ($path_fragment) {
            return "<?php echo starts_with(Request::path(), $path_fragment) ? 'active' : ''; ?>";
        });

        Subcategory::observe(SubcategoryObserver::class);
        Category::observe(CategoryObserver::class);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(Secretary::class, function($app) {
            return new Secretary([
                'email' => 'test@example.com',
                'slack' => null
            ]);
        });
    }
}
