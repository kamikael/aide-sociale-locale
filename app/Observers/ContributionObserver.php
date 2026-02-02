<?php

namespace App\Observers;

use App\Models\Contribution;

class ContributionObserver
{
    /**
     * Handle the Contribution "created" event.
     */
    public function created(Contribution $contribution): void
    {
        //
    }

    /**
     * Handle the Contribution "updated" event.
     */
    public function updated(Contribution $contribution): void
    {
        //
    }

    /**
     * Handle the Contribution "deleted" event.
     */
    public function deleted(Contribution $contribution): void
    {
        //
    }

    /**
     * Handle the Contribution "restored" event.
     */
    public function restored(Contribution $contribution): void
    {
        //
    }

    /**
     * Handle the Contribution "force deleted" event.
     */
    public function forceDeleted(Contribution $contribution): void
    {
        //
    }
}
