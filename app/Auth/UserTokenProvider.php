<?php

namespace App\Auth;

use App\DataProvider\UserTokenProviderInterface;
use App\Entity\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\UserProvider;

/**
 * APIアプリケーション用の独自認証プロバイダ例
 */
class UserTokenProvider implements UserProvider
{
    private $provider;

    public function __construct(UserTokenProviderInterface $provider)
    {
        $this->provider = $provider;
    }

    public function retrieveById($identifier)
    {
        return null;
    }

    public function retrieveByToken($identifier, $token)
    {
        return null;
    }

    public function updateRememberToken(Authenticatable $user, $token)
    {
        // APIアプリケーションで自動ログインは利用できない為、処理を記述しない
    }

    public function retrieveByCredentials(array $credentials)
    {
        if (!isset($credentials['api_token'])) {
            return null;
        }
        // トークンでユーザー情報を取得
        $result = $this->provider->retrieveUserByToken($credentials['api_token']);
        if (is_null($result)) {
            return null;
        }

        // Authenticatableインターフェースの実装クラスのインスタンスを返却することで、認証処理後にユーザー情報にアクセスできる
        return new User(
            $result->user_id,
            $result->api_token,
            $result->name,
            $result->email
        );
    }

    public function validateCredentials(Authenticatable $user, array $credentials)
    {
        // APIアプリケーションではパスワード認証は利用しない為、利用された場合にログインできないことを示すためのfalse
        return false;
    }
}