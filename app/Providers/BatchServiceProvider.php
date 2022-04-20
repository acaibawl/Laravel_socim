<?php
declare(strict_types=1);

namespace App\Providers;

use App\Console\Commands\SendOrdersCommand;
use App\Services\ExportOrdersService;
use App\UseCases\SendOrderUseCase;
use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\MessageFormatter;
use GuzzleHttp\Middleware;
use Illuminate\Support\ServiceProvider;

class BatchServiceProvider extends ServiceProvider
{
  public function register()
  {
    $this->app->bind(SendOrdersCommand:: class, function () {
      $useCase = app(SendOrderUseCase::class);
      // ロガーのログファイルパスを他のログと分ける
      $logger = app('log');
      $logger->useFiles(storage_path() . '/logs/send-orders.log');

      return new SendOrdersCommand($useCase, $logger);
    });

    $this->app->bind(SendOrderUseCase::class, function() {
      $service = $this->app->make(ExportOrdersService::class);
      // Guzzleにログ用ミドルウェアを追加
      $guzzle = new Client([
        'handler' => tap(HandlerStack::create(), function (HandlerStack $v) {
          $logger = $this->app->make('log');
          $v->push(Middleware::log(
            $logger->getMonolog(),
            new MessageFormatter(
              ">>>\n{req_headers}\n<<<\n{res_headers}\n\n{res_body}"
            )
          ));
        }),
      ]);

      return new SendOrderUseCase($service, $guzzle);
    });
  }
}
