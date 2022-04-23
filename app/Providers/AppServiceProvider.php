<?php

namespace App\Providers;

use Knp\Snappy\Pdf;
use RuntimeException;
use App\BlowfishEncrypter;
use App\DataProvider\Database\RegisterReviewDataProvider;
use App\DataProvider\RegisterReviewProviderInterface;
use Illuminate\Support\Str;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('encrypter', function ($app) {
            $config = $app->make('config')->get('app');

            if (Str::startsWith($key = $this->key($config), 'base64:')) {
                $key = base64_decode(substr($key, 7));
            }
            return new BlowfishEncrypter($key);
        });

        $this->app->bind(
            \App\DataProvider\FavoriteRepositoryInterface::class,
            \App\DataProvider\FavoriteRepository::class
        );

        // コンストラクタインジェクション、およびメソッドインジェクションで、
        // Knp\Snappy\Pdfと型宣言されていれば、無名関数で記述した通りにインスタンス生成が行われ、
        // 利用するクラスにオブジェクトが渡されます。
        $this->app->bind(Pdf::class, function() {
            return new Pdf('/usr/local/bin/wkhtmltopdf');
        });

        $this->app->bind(RegisterReviewProviderInterface::class, function() {
            return new RegisterReviewDataProvider();
        });
    }

    protected function key(array $config)
    {
        return tap($config['key'], function ($key) {
            if (empty($key)) {
                throw new RuntimeException(
                    'No application encryption key has been specified.'
                );
            }
        });
    }
}
