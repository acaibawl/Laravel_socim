<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class UserResource extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->resource['user_id'],
            'name' => $this->resource['user_name'],
            '_links' => [
                'self' => [
                    'href' => sprintf(
                        'https://example.com/users/%s',
                        $this->resource['user_id'],
                    )
                ]
            ]
        ];
    }
}
