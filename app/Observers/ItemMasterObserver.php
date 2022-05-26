<?php

namespace App\Observers;

use App\Models\ItemMaster;

class ItemMasterObserver
{
    /**
     * Handle the ItemMaster "created" event.
     *
     * @param    \App\Models\ItemMaster  $ItemMaster
     * @return  void
     */
    public function created(ItemMaster $ItemMaster)
    {
    }

    /**
     * Handle the ItemMaster "updated" event.
     *
     * @param    \App\Models\ItemMaster  $ItemMaster
     * @return  void
     */
    public function updated(ItemMaster $ItemMaster)
    {
    }

    /**
     * Handle the ItemMaster "deleted" event.
     *
     * @param    \App\Models\ItemMaster  $ItemMaster
     * @return  void
     */
     public function deleted(ItemMaster $ItemMaster)
    {
        //
    }

    /**
     * Handle the ItemMaster "restored" event.
     *
     * @param    \App\Models\ItemMaster  $ItemMaster
     * @return  void
     */
    public function restored(ItemMaster $ItemMaster)
    {
        //
    }

    /**
     * Handle the ItemMaster "force deleted" event.
     *
     * @param    \App\Models\ItemMaster  $ItemMaster
     * @return  void
     */
    public function forceDeleted(ItemMaster $ItemMaster)
    {
        //
    }
}
