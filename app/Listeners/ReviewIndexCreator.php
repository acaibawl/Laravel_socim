<?php
declare(strict_types=1);

namespace App\Listeners;

use App\DataProvider\AddReviewIndexProviderInterface;
use App\Events\ReviewRegistered;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class ReviewIndexCreator implements ShouldQueue
{
    use InteractsWithQueue;

    private $provider;
    
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(AddReviewIndexProviderInterface $provider)
    {
        $this->provider = $provider;
    }

    /**
     * Handle the event.
     *
     * @param  ReviewRegistered  $event
     * @return void
     */
    public function handle(ReviewRegistered $event)
    {
        $this->provider->addReview(
            $event->getId(),
            $event->getTitle(),
            $event->getContent(),
            $event->getCreatedAtEpoch(),
            $event->getTags(),
            $event->getUserId(),
        );
    }
}
