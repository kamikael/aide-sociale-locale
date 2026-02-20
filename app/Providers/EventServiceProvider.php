<?php

namespace App\Providers;

use App\Models\Cagnotte;
use App\Policies\CagnottePolicy;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    
   protected $listen = [
    \App\Events\DonCreated::class => [
        \App\Listeners\UpdateCagnotteAmount::class,
        \App\Listeners\SendDonationNotification::class,
    ],
];


    public function boot(): void
    {
        $this->registerPolicies();
    }
}
