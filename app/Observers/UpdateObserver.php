<?php

namespace App\Observers;

use App\Models\Update;

class UpdateObserver
{
    /**
     * Handle the Update "creating" event.
     */
    public function creating(Update $update): void
    {
        $update->downloads = 0;
    }

    /**
     * Handle the Update "created" event.
     */
    public function created(Update $update): void
    {
        //
    }

    /**
     * Handle the Update "updated" event.
     */
    public function updated(Update $update): void
    {
        //
    }

    /**
     * Handle the Update "deleted" event.
     */
    public function deleted(Update $update): void
    {
        //
    }

    /**
     * Handle the Update "restored" event.
     */
    public function restored(Update $update): void
    {
        //
    }

    /**
     * Handle the Update "force deleted" event.
     */
    public function forceDeleted(Update $update): void
    {
        //
    }
}
