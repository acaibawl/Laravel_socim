<?php
declare(strict_types=1);

namespace App\Services;

use App\Model\PointEvent;
use App\Eloquent\CustomerPoint;
use Illuminate\Database\Connection;
use App\Eloquent\CustomerPointEvent;

final class AddPointService
{
  private CustomerPointEvent $customerPointEvent;
  private CustomerPoint $customerPoint;
  private Connection $db;

  /**
   * @param CustomerPointEvent $customerPointEvent
   * @param CustomerPoint $customerPoint
   */
  public function __construct(
    CustomerPointEvent $customerPointEvent,
    CustomerPoint $customerPoint
  ) {
    $this->customerPointEvent = $customerPointEvent;
    $this->customerPoint = $customerPoint;
    $this->db = $customerPointEvent->getConnection();;
  }

  public function add(PointEvent $event)
  {
    $this->db->transaction(function () use ($event) {
      // ポイントイベント処理
      $this->customerPointEvent->register($event);

      // 保有ポイント更新
      $this->customerPoint->addPoint(
        $event->getCustomerId(),
        $event->getPoint()
      );
    });
  }
}
