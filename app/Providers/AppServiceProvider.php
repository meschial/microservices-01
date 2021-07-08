<?php

namespace App\Providers;

use App\Models\{
    Category,
    Company
};
use App\Observers\{
    CategoryObserver,
    CompanyObeserve
};
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Category::observe(CategoryObserver::class);
        Company::observe(CompanyObeserve::class);
    }
}
