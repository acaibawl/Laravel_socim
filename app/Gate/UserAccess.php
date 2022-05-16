<?php
declare(strict_types=1);

namespace App\Gate;

use App\User;
use function intval;

class UserAccess
{
    public function __invoke(User $user, string $id): bool
    {
        // 引数の$userにはログイン中のUserが渡される
        return intval($user->getAuthIdentifier()) === intval($id);
    }
}