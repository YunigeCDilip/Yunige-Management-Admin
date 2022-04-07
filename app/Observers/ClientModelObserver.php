<?php

namespace App\Observers;

use App\Models\Client;

class ClientModelObserver
{
    /**
     * Handle the Client "created" event.
     *
     * @param Client $client
     * @return void
     */
    public function creating(Client $client)
    {
        $latestData = Client::withTrashed()->max('serial_number');
        $sn = ($latestData) ? $latestData : 0;
        $clientDisplay = "";
        if($client->ja_name == "" && $client->en_name == "") $clientDisplay = "_".'c'.sprintf("%04s", $sn+1);
        else if($client->ja_name == "") $clientDisplay = $client->en_name."_".'c'.sprintf("%04s", $sn+1);
        else if($client->en_name == "") $clientDisplay = $client->ja_name."_".'c'.sprintf("%04s", $sn+1);
        else $clientDisplay = $client->en_name."-".$client->ja_name."_".'c'.sprintf("%04s", $sn+1);

        $client->serial_number = $sn+1;
        $client->client_name = $clientDisplay;
    }

    /**
     * Handle the Client "updated" event.
     *
     * @param Client $client
     * @return void
     */
    public function updating(Client $client)
    {
        $latestData = Client::withTrashed()->max('serial_number');
        $sn = ($latestData) ? $latestData : 0;
        $clientDisplay = "";
        if($client->ja_name == "" && $client->en_name == "") $clientDisplay = "_".'c'.sprintf("%04s", $sn+1);
        else if($client->ja_name == "") $clientDisplay = $client->en_name."_".'c'.sprintf("%04s", $sn+1);
        else if($client->en_name == "") $clientDisplay = $client->ja_name."_".'c'.sprintf("%04s", $sn+1);
        else $clientDisplay = $client->en_name."-".$client->ja_name."_".'c'.sprintf("%04s", $sn+1);

        $client->serial_number = $sn+1;
        $client->client_name = $clientDisplay;
    }
}
