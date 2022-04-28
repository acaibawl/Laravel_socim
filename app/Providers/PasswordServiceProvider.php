<?php
declare(strict_types=1);

namespace App\Providers;

use App\Auth\PasswordManager;
use Illuminate\Auth\Passwords\PasswordResetServiceProvider;
use Illuminate\Foundation\Application;

class PasswordServiceProvider extends  PasswordResetServiceProvider
{
    protected function registerPasswordBroker()
    {
        // パスワードリセット機能を登録
        $this->app->singleton('auth.password', function (Application $app) {
            return new PasswordManager($app);
        });
        // パスワードリセットを実行する機能を登録（上書き）
        $this->app->bind('auth.password.broker', function (Application $app) {
            return $app->make('auth.password')->broker();
        });
    }

}