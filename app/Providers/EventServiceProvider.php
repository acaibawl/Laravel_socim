<?php

namespace App\Providers;

use App\CustomNamespace\PublishProcessor;
use App\Listeners\MessageQueueSubscriber;
use App\Listeners\MessageSubscriber;
use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\Event' => [
            'App\Listeners\EventListener',
        ],
        // 会員登録イベントのリスナーを発行（追加）
        'Illuminate\Auth\Events\Registered' => [
            'App\Listeners\RegisteredListener',
        ],
        PublishProcessor::class => [
            MessageSubscriber::class,
            MessageQueueSubscriber::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
