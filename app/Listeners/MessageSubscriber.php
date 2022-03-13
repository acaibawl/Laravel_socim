<?php

namespace App\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use App\CustomNamespace\PublishProcessor;
use Illuminate\Contracts\Queue\ShouldQueue;

class MessageSubscriber
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  PublishProcessor  $event
     * @return void
     */
    public function handle(PublishProcessor $event)
    {
        var_dump('test');
        var_dump($event->getInt());
    }
}
