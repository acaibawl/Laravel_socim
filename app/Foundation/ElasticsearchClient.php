<?php
declare(strict_types=1);

namespace App\Foundation;

use Elasticsearch\Client;
use Elasticsearch\ClientBuilder;
use Illuminate\Support\Facades\Log;

class ElasticsearchClient
{
  protected $hosts;

  public function __construct(array $hosts) {
    Log::debug("hosts:" . implode(",", $hosts));
    $this->hosts = $hosts;
  }

  public function client(): Client
  {
    return ClientBuilder::create()->setHosts($this->hosts)
      ->build();
  }
}
