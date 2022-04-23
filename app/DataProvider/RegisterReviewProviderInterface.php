<?php
declare(strict_types=1);

namespace App\DataProvider;

interface RegisterReviewProviderInterface
{
  public function registerReview(
    string $title,
    string $content,
    int $userId,
    string $createdAt,
    array $tags = []
  ): int;
}
