<?php

namespace App\DataProvider;

interface AddReviewIndexProviderInterface
{
  public function addReview(
    int $id,
    string $title,
    string $content,
    string $epoch,
    array $tags,
    int $userId
  );
}
