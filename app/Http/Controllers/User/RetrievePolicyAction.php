<?php

namespace App\Http\Controllers\User;

use Illuminate\Auth\AuthManager;
use Illuminate\Contracts\Auth\Access\Gate;

class RetrievePolicyAction extends \App\Http\Controllers\Controller
{
    private $authManager;
    private $gate;

    public function __construct(AuthManager $authManager, Gate $gate)
    {
        $this->authManager = $authManager;
        $this->gate = $gate;
    }

    public function __invoke(string $id)
    {
        $class = new \stdClass();
        $class->id = 3;
        return json_encode(
                $this->gate->forUser(
                $this->authManager->guard()->user()
            )->allows('edit', $class)
        );
    }
}