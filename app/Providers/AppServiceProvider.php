<?php

namespace App\Providers;

use App\Models\Attendee;
use App\Models\Event;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;

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

        Route::middleware('api')
            ->group(base_path('routes/api.php'));

        // Gate::define('update-event', function ($user, Event $event) {});

        // Gate::define('delete-attendee', function ($user, Event $event, Attendee $attendee) {});
    }
}
