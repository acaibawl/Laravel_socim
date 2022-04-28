<?php
declare(strict_types=1);

namespace App\Auth;

use Illuminate\Auth\Passwords\PasswordBrokerManager;
use Illuminate\Support\Str;

class PasswordManager extends PasswordBrokerManager
{
    // パスワードリセットのデータベース操作拡張例
    protected function createTokenRepository(array $config)
    {
        $key = $this->app['config']['app.key'];

        if (Str::startswith($key, 'base64:')) {
            $key = base64_decode(substr($key, 7));
        }

        $connection = $config['connection'] ?? null;

        // アプリケーション仕様に合わせた独自のパスワードリセット処理
        // Illuminat\Auth\Password\DatabaseTokenRepositoryを継承したクラスのインスタンスを返却
        return new CustomeTokenRepository(
            $this->app['db']->connection($connection),
            $this->app['hash'],
            $config['table'],
            $key,
            $config['expire']
        );
    }
}