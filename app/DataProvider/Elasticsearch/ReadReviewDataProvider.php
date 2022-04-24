<?php

declare(strict_types=1);

namespace App\DataProvider\Elasticsearch;

use App\Foundation\ElasticsearchClient;

class ReadReviewDataProvider
{
  private $client;

  public function __construct(ElasticsearchClient $client)
  {
    $this->client = $client;
  }

  public function findAllByTag(array $tags): array
  {
    $result = $this->client->client()->search([
      'index' => 'reviews',
      'type' => 'reviews',
      'body' => [
        'query' => [
          'bool' => [
            'should' => array_map(function (string $value) {
              return [
                'match_phrase' => [
                  'tags.tag_name' => $value
                ]
              ];
            }, $tags),
          ]
        ]
      ],
    ]);
    $map = [];
    if (count($result)) {
      foreach ($result['hits']['hits'] as $hit) {
        $map[] = $hit['_source'];
      }
    }
    return $map;
  }
}
