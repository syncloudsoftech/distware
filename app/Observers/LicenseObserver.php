<?php

namespace App\Observers;

use App\Models\License;
use App\Models\Machine;
use Illuminate\Support\Str;

class LicenseObserver
{
    /**
     * Handle the License "creating" event.
     */
    public function creating(License $license): void
    {
        if (empty($license->code)) {
            $code = generate_key(
                config('fixtures.licensing.length'),
                config('fixtures.licensing.segment_length'));
            if (config('fixtures.licensing.uppercase')) {
                $code = Str::upper($code);
            }

            $license->code = $code;
        }
    }

    /**
     * Handle the License "created" event.
     */
    public function created(License $license): void
    {
        //
    }

    /**
     * Handle the License "updated" event.
     */
    public function updated(License $license): void
    {
        //
    }

    /**
     * Handle the License "deleting" event.
     */
    public function deleting(License $license): void
    {
        $license->machines()
            ->each(function (Machine $machine) {
                $machine->delete();
            });
    }

    /**
     * Handle the License "deleted" event.
     */
    public function deleted(License $license): void
    {
        //
    }

    /**
     * Handle the License "restored" event.
     */
    public function restored(License $license): void
    {
        //
    }

    /**
     * Handle the License "force deleted" event.
     */
    public function forceDeleted(License $license): void
    {
        //
    }
}
