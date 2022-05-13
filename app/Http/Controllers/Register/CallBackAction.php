<?php
declare(strict_types=1);

namespace App\Http\Controllers\Register;

use App\Http\Controllers\Controller;
use App\User;
use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\MessageFormatter;
use GuzzleHttp\Middleware;
use Illuminate\Auth\AuthManager;
use Laravel\Socialite\Contracts\Factory;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\GithubProvider;
use Psr\Log\LoggerInterface;

class CallBackAction extends Controller
{
    public function __invoke(
        Factory $factory,
        AuthManager $authManager,
        LoggerInterface $log
    )
    {

        // Socialiteのメソッドを通してコールバックから受け取ったユーザー情報を取得する
        $user = $factory-> driver('github')->user();

        // 外部サービスから取得したユーザー情報をパスワード"password"でDBに登録し、ログインする。本当はパスワードなしにしたいけど、マイグレーション作るのがめんどうなので。。。
        $authManager->guard()->login(
            User::firstOrCreate([
                'name' => $user->getName() ?? 'no_name',
                'email' => $user->getEmail(),
                'password' => 'password',
            ]),
            true
        );

        return redirect('/');

    }
}