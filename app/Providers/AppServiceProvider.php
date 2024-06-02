<?php

namespace App\Providers;

use App\Models\Job;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Gate;
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
        // To Disable the lazy loading we just need to do the below step
        // Model::preventLazyLoading();

        // Gate::define('edit-job', function(?User $user, Job $job){
        Gate::define('edit-job', function(User $user, Job $job){
            return $job->employer->user->is($user);
        });
    }
}
