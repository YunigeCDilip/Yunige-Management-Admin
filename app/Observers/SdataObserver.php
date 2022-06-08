<?php

namespace App\Observers;

use App\Models\Sdata;

class SdataObserver
{
    /**
     * Handle the Sdata "created" event.
     *
     * @param    \App\Models\Sdata  $Sdata
     * @return  void
     */
    public function created(Sdata $Sdata)
    {
    }

    /**
     * Handle the Sdata "updated" event.
     *
     * @param    \App\Models\Sdata  $Sdata
     * @return  void
     */
    public function updated(Sdata $Sdata)
    {
    }

    /**
     * Handle the Sdata "deleted" event.
     *
     * @param    \App\Models\Sdata  $Sdata
     * @return  void
     */
     public function deleted(Sdata $Sdata)
    {
        //
    }

    /**
     * Handle the Sdata "restored" event.
     *
     * @param    \App\Models\Sdata  $Sdata
     * @return  void
     */
    public function restored(Sdata $Sdata)
    {
        //
    }

    /**
     * Handle the Sdata "force deleted" event.
     *
     * @param    \App\Models\Sdata  $Sdata
     * @return  void
     */
    public function forceDeleted(Sdata $Sdata)
    {
        //
    }
}
