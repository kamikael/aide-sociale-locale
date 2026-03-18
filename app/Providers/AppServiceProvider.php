<?php

namespace App\Providers;

use App\Events\DonCreated;
use App\Listeners\SendDonationNotification;
use App\Listeners\UpdateCagnotteAmount;
use Illuminate\Support\Facades\Event;
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
        Event::listen(DonCreated::class, UpdateCagnotteAmount::class);
        Event::listen(DonCreated::class, SendDonationNotification::class);
    }
}
