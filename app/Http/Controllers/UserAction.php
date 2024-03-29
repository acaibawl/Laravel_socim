<?php

namespace App\Http\Controllers;

use Illuminate\Auth\AuthManager;
use Illuminate\Http\Request;

class UserAction extends Controller
{
    private $authManager;

    public function __construct(AuthManager $authManager)
    {
        $this->authManager = $authManager;
    }

    public function __invoke(Request $request)
    {
        // 認証したユーザ情報へアクセス
        // ヘッダのAuthorizationに設定したBearer xxxがuser_tokenと一致するユーザを取得
         $user = $this->authManager->guard('api')->user();
        // Authファサードを利用してもOK
        // ユーザのidを表示してみる
        dd('$user = ' . $user->getAuthIdentifier());
    }
}