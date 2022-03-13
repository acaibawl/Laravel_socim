<?php

namespace App\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use App\CustomNamespace\PublishProcessor;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;

class MessageQueueSubscriber implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Handle the event.
     *
     * @param  PublishProcessor  $event
     * @return void
     */
    public function handle(PublishProcessor $event)
    {
        Log::info($event->getInt());
    }
}
