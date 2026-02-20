<?php

namespace App\Providers;

use App\Models\Cagnotte;
use App\Policies\CagnottePolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    
    protected $policies = [
        Cagnotte::class => CagnottePolicy::class,
    ];

    public function boot(): void
    {
        $this->registerPolicies();
    }
}
