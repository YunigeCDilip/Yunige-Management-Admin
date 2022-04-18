<?php

namespace App\Observers;

use App\Models\Client;
use App\Models\AmazonProgress;

class AmazonProgressObserver
{
    /**
     * Handle the AmazonProgress "creating" event.
     *
     * @param AmazonProgress $amazon
     * @return void
     */
    public function creating(AmazonProgress $amazon)
    {
        $data = explode('_', $amazon->status);
        $client = Client::find($data[0]);
        $clientDisplay = "".$client->client_name."";
        if($amazon->status != "") $clientDisplay .= "-".$amazon->status;
        if($amazon->pickup != "") $clientDisplay .= "-".$amazon->pickup;

        $amazon->name = $clientDisplay;
        $amazon->status = $data[1];
    }

    /**
     * Handle the AmazonProgress "updating" event.
     *
     * @param AmazonProgress $amazon
     * @return void
     */
    public function updating(AmazonProgress $amazon)
    {
        $data = explode('_', $amazon->status);
        $client = Client::find($data[0]);
        $clientDisplay = "".$client->client_name."";
        if($amazon->status != "") $clientDisplay .= "-".$amazon->status;
        if($amazon->pickup != "") $clientDisplay .= "-".$amazon->pickup;

        $amazon->name = $clientDisplay;
        $amazon->status = $data[1];
    }
}
