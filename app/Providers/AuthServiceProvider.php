<?php

namespace App\Providers;

use App\Auth\CacheUserProvider;
use App\Auth\UserTokenProvider;
use App\DataProvider\Database\UserToken;
use App\Gate\UserAccess;
use App\Policies\ContentPolicy;
use App\User;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Gate;
use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Psr\Log\LoggerInterface;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
        \stdClass::class => ContentPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot(GateContract $gate, LoggerInterface $logger)
    {
        $this->registerPolicies();

        // 'user-access'という名前の認可処理を定義
        $gate->define('user-access', new UserAccess());
        $gate->before(function ($user, $ability) use ($logger) {
            $logger->info($ability, [
                'user_id' => $user->getAuthIdentifier()
            ]);
        });

//        $this->app['auth']->provider(
//            'cache_eloquent',
//            function (Application $app, array $config) {
//                return new CacheUserProvider(
//                    $app['hash'],
//                    $config['model'],
//                    $app['cache']
//                );
//            }
//        );
        $this->app['auth']->provider(
            'user_token',
            function (Application $app) {
                return new UserTokenProvider(new UserToken($app['db']));
            }
        );
    }
}
