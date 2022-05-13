<?php
declare(strict_types=1);

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Responder\TokenResponder;
use Illuminate\Auth\AuthManager;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Tymon\JWTAuth\JWTGuard;

class LoginAction extends Controller
{
    private $authManager;

    public function __construct(AuthManager $authManager)
    {
        $this->authManager = $authManager;
    }

    public function __invoke(Request $request, TokenResponder $responder): JsonResponse
    {
        // confic/auth.phpに定義したjwt-apiのguard（認証方法）オブジェクトを呼び出す
        /** @var JWTGuard $guard */
        $guard = $this->authManager->guard('jwt-api');
        // 認証できた場合はtokenが生成される
        $token = $guard->attempt([
            'email' => $request->get('email'),
            'password' => $request->get('password'),
        ]);

        return $responder(
            $token,
            $guard->factory()->getTTL() * 60
        );
    }
}