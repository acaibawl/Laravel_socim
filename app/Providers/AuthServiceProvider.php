<?php

namespace App\Providers;

use App\Auth\CacheUserProvider;
use App\Auth\UserTokenProvider;
use App\DataProvider\Database\UserToken;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

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
