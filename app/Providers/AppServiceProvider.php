<?php

namespace App\Providers;

use App\Models\Appointment;
use App\Observers\AppointmentObserver;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Appointment::observe(AppointmentObserver::class);

        if ($this->app->environment('production')) {
            URL::forceScheme('https');
        }
    }
}
