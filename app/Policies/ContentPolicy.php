<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Contracts\Auth\Authenticatable;
use stdClass;

class ContentPolicy
{
    use HandlesAuthorization;

    public function edit(
        Authenticatable $authenticatable,
        stdClass $class
    ): bool {
        if (property_exists($class, 'id')) {
            return intval($authenticatable->getAuthIdentifier()) === intval($class->id);
        }

        return false;
    }
}
