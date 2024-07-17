<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Database\Connection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Lottery;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Laravel\Pennant\Feature;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrap();

        //added by mutaman to disable lazy loading and force eager loading
        Model::preventLazyLoading(!app()->isProduction());
        // end

         DB::whenQueryingForLongerThan(500, function (Connection $connection) {
         Log::warning("Database queries exceeded 5 seconds on {$connection->getName()}");
        //or notify the development team...
         });

        //Features Section
        Feature::define('vue-homepage', fn (User $user) => match (true) {
        //$user->isInternalTeamMember() => true,
        //$user->isHighTrafficCustomer() => false,
            default => Lottery::odds(1 / 5),
        });
    }
}
