<?php
namespace App\Application\Providers;

use Illuminate\Support\ServiceProvider;
 
class RepositoryServiceProvider extends ServiceProvider
{
    public function register()
    {

        /*
        *   Backend Repositories and Contracts
        */
        \App::bind('App\\Application\\Contracts\\WarehouseDataContract', 'App\\Application\\Repositories\\WarehouseDataRepository');
        \App::bind('App\\Application\\Contracts\\UserContract', 'App\\Application\\Repositories\\UserRepository');
        \App::bind('App\\Airtable\\ApiClient', 'App\\Airtable\\AirtableApiClient');
    }
}
