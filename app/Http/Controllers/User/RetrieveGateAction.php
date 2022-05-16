<?php

namespace App\Http\Controllers\User;

use Illuminate\Auth\AuthManager;
use Illuminate\Contracts\Auth\Access\Gate;

class RetrieveGateAction extends \App\Http\Controllers\Controller
{
    private $authManager;
    private $gate;

    public function __construct(
        AuthManager $authManager,
        Gate  $gate
    )
    {
        $this->authManager = $authManager;
        $this->gate = $gate;
    }

    public function __invoke(string $id)
    {
//        if ($this->gate->allows('user-access', $id)) {
//            // 実行が許可される場合に実行
//        }
        return $this->gate->allows('user-access', $id);
    }
}