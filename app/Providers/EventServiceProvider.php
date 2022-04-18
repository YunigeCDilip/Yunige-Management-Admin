<?php

namespace App\Providers;

use App\Models\Client;
use App\Models\AmazonProgress;
use Illuminate\Support\Facades\Event;
use App\Observers\ClientModelObserver;
use Illuminate\Auth\Events\Registered;
use App\Observers\AmazonProgressObserver;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        Client::observe(ClientModelObserver::class);
        AmazonProgress::observe(AmazonProgressObserver::class);
    }
}
