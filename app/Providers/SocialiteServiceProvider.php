<?php
declare(strict_types=1);

namespace App\Providers;

use App\Foundation\Socialite\AmazonProvider;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider;
use Laravel\Socialite\Contracts\Factory;
use Laravel\Socialite\SocialiteManager;

class SocialiteServiceProvider extends ServiceProvider
{
    /**
     * @param Factory|SocialiteManager $factory
     * @return void
     */
    public function boot(Factory $factory)
    {
        // socialiteにamazon認証プロバイダを追加
        $factory->extend('amazon', function (Application $app) use ($factory) {
            return $factory->buildProvider(
                AmazonProvider::class,
                $app['config']['service.amazon']
            );
        });
    }
}