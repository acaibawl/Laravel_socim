<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use App\DataProvider\Eloquent\Favorite;
use App\DataProvider\FavoriteRepositoryInterface;

class FavoriteService
{
  private $favorite;

  public function __construct(FavoriteRepositoryInterface $favorite)
  {
    $this->favorite = $favorite;
  }
  public function switchFavorite(int $bookId, int $userId, string $createdAt): int
  {
    return $this->favorite->switch($bookId, $userId, $createdAt);
  }
}
