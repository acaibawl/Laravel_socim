<?php

namespace App\CustomNamespace;

class PublishProcessor
{
    private $int;

    public function __construct(int $int)
    {
        $this->int = $int;
    }

    public function getInt(): int
    {
        return $this->int;
    }
}
