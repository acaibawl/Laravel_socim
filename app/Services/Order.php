<?php

namespace App\Services;

use App\CustomNamespace\PublishProcessor;
use Illuminate\Support\Facades\Event;

class Order
{
  const DISABLE_NOTIFICATION = 1;

  public function run(Customer $customer)
  {
    // 特定条件時にイベントを無効化する
    if ($customer->getStatus() === self::DISABLE_NOTIFICATION) {
      if (Event::hasListeners(PublishProcessor::class)) {
        Event::forget(PublishProcessor::class);
      }
    }
    Event::dispatch(new PublishProcessor($customer->getId()));
  }
}
