<?php

namespace App\Observers;

use App\Models\Wdata;

class WdataObserver
{
    /**
     * Handle the Wdata "created" event.
     *
     * @param Wdata $wdata
     * @return void
     */
    public function creating(Wdata $wdata)
    {
        $latestData = Wdata::withTrashed()->max('serial_number');
        $sn = ($latestData) ? $latestData : 0;
        $warehouseNumber = 'w'.sprintf("%04s", $sn+1);

        $wdata->serial_number = $sn+1;
        $wdata->warehouse_number = $warehouseNumber;
        $wdata->name = $warehouseNumber.'_'.$wdata->client_name;
    }
}
