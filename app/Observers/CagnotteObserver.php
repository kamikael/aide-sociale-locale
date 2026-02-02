<?php

namespace App\Observers;

use App\Models\Cagnotte;

class CagnotteObserver
{
    /**
     * Handle the Cagnotte "created" event.
     */
    public function created(Cagnotte $cagnotte): void
    {
        //
    }

    /**
     * Handle the Cagnotte "updated" event.
     */
    public function updated(Cagnotte $cagnotte): void
    {
        //
    }

    /**
     * Handle the Cagnotte "deleted" event.
     */
    public function deleted(Cagnotte $cagnotte): void
    {
        //
    }

    /**
     * Handle the Cagnotte "restored" event.
     */
    public function restored(Cagnotte $cagnotte): void
    {
        //
    }

    /**
     * Handle the Cagnotte "force deleted" event.
     */
    public function forceDeleted(Cagnotte $cagnotte): void
    {
        //
    }
}
