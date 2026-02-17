<?php

namespace App\Listeners;

use App\Events\DonCreated;
use App\Services\CommissionService;

class CreerCommissionPourDon
{
    public function __construct(
        protected CommissionService $commissionService
    ) {}

    public function handle(DonCreated $event): void
    {
        $this->commissionService->creerPourDon($event->don);
    }
}
