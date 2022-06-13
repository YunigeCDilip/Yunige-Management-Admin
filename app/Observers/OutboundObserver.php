<?php

namespace App\Observers;

use App\Models\Outbound;

class OutboundObserver
{
    /**
     * Handle the Outbound "created" event.
     *
     * @param    \App\Models\Outbound  $Outbound
     * @return  void
     */
    public function created(Outbound $Outbound)
    {
    }

    /**
     * Handle the Outbound "updated" event.
     *
     * @param    \App\Models\Outbound  $Outbound
     * @return  void
     */
    public function updated(Outbound $Outbound)
    {
    }

    /**
     * Handle the Outbound "deleted" event.
     *
     * @param    \App\Models\Outbound  $Outbound
     * @return  void
     */
     public function deleted(Outbound $Outbound)
    {
        //
    }

    /**
     * Handle the Outbound "restored" event.
     *
     * @param    \App\Models\Outbound  $Outbound
     * @return  void
     */
    public function restored(Outbound $Outbound)
    {
        //
    }

    /**
     * Handle the Outbound "force deleted" event.
     *
     * @param    \App\Models\Outbound  $Outbound
     * @return  void
     */
    public function forceDeleted(Outbound $Outbound)
    {
        //
    }
}
