<?php
declare(strict_types=1);

namespace App\Model;

use Carbon\Carbon;

class PointEvent
{
  private int $customerId;
  private string $event;
  private int $point;
  private Carbon $createdAt;

  /**
   * @param integer $customerId
   * @param string $event
   * @param integer $point
   * @param Carbon $createdAt
   */
  public function __construct(
    int $customerId,
    string $event,
    int $point,
    Carbon $createdAt
  ) {
    $this->customerId = $customerId;
    $this->event = $event;
    $this->point = $point;
    $this->createdAt = $createdAt;
  }

  /**
   * @return integer
   */
  public function getCustomerId(): int
  {
    return $this->customerId;
  }

  /**
   * @return string
   */
  public function getEvent(): string
  {
    return $this->event;
  }

  /**
   * @return integer
   */
  public function getPoint(): int
  {
    return $this->point;
  }

  /**
   * @return Carbon
   */
  public function getCreatedAt(): Carbon
  {
    return $this->createdAt->copy();
  }

}
