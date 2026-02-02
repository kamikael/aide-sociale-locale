<?php

namespace App\Observers;

use App\Models\Don;

class DonObserver
{
    /**
     * Handle the Don "created" event.
     */
    public function created(Don $don): void
    {
        //
    }

    /**
     * Handle the Don "updated" event.
     */
    public function updated(Don $don): void
    {
        //
    }

    /**
     * Handle the Don "deleted" event.
     */
    public function deleted(Don $don): void
    {
        //
    }

    /**
     * Handle the Don "restored" event.
     */
    public function restored(Don $don): void
    {
        //
    }

    /**
     * Handle the Don "force deleted" event.
     */
    public function forceDeleted(Don $don): void
    {
        //
    }
}
