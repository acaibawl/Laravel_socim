<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class ReviewRegistered
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private $id;
    private $title;
    private $content;
    private $userId;
    private $tags = [];
    private $createdAt;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(
        int $id,
        string $title,
        string $content,
        int $userId,
        array $tags,
        string $createdAt
    ) {
        $this->id = $id;
        $this->title = $title;
        $this->content = $content;
        $this->userId = $userId;
        $this->tags = $tags;
        $this->createdA = $createdAt;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function getCreatedAtEpoch(): string
    {
        $datetime = new \DateTime($this->createdAt);
        return $datetime->format('U');
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getTags(): array
    {
        return $this->tags;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }
}
