<?php
declare(strict_types=1);

namespace App\UseCases;

use Carbon\Carbon;
use GuzzleHttp\Client;
use App\Services\ExportOrdersService;

class SendOrderUseCase
{
  /** @var ExportOrdersService */
  private ExportOrdersService $service;

  /** @var Client */
  private Client $guzzle;

  public function __construct(ExportOrdersService $service, Client $guzzle)
  {
    $this->service = $service;
    $this->guzzle = $guzzle;
  }

  public function run(Carbon $targetDate): int
  {
    // データベースから購入情報を取得
    $orders = $this->service->findOrders($targetDate);

    // 送信用データを作成
    $json = collect();

    $order = null;
    foreach ($orders as $detail) {
      if ($detail->detail_no === 1) {
        if (is_array($order)) {
          $json->push($order);
        }
        $order = [
          'order_code' => $detail->order_code,
          'order_date' => $detail->order_date,
          'total_price' => $detail->total_price,
          'total_quantity' => $detail->total_quantity,
          'customer_name' => $detail->customer_name,
          'customer_email' => $detail->customer_email,
          'destination_name' => $detail->destination_name,
          'destination_zip' => $detail->destination_zip,
          'destination_prefecture' => $detail->destination_prefecture,
          'destination_address' => $detail->destination_address,
          'destination_tel' => $detail->destination_tel,
          'order_details' => [],
        ];
      }
      $order['order_details'][] = [
        'detail_no' => $detail->detail_no,
        'item_name'  => $detail->item_name,
        'item_price'  => $detail->item_praice,
        'quantity'  => $detail->quantity,
        'subtotal_price'  => $detail->subtotal_price,
      ];
    }
    if (is_array($order)) {
      $json->push($order);
    }

    // JSONを送信
    $url = config('batch.import-orders-url');
    $this->guzzle->post($url, [
      'json' => $json
    ]);

    return $json->count();
  }
}
