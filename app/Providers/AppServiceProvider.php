<?php
declare(strict_types=1);

namespace App\Providers;

use Knp\Snappy\Pdf;
use RuntimeException;
use App\BlowfishEncrypter;
use Illuminate\Support\Str;
use Illuminate\Foundation\Application;
use App\Foundation\ElasticsearchClient;
use Illuminate\Support\ServiceProvider;
use App\DataProvider\AddReviewIndexProviderInterface;
use App\DataProvider\RegisterReviewProviderInterface;
use App\DataProvider\Database\RegisterReviewDataProvider;
use App\DataProvider\Elasticsearch\AddReviewIndexDataProvider;

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

        $this->app->singleton(ElasticsearchClient::class, function (Application $app) {
            $config = $app['config']->get('elasticsearch');
            return new ElasticsearchClient($config['hosts']);
        });

        $this->app->bind(AddReviewIndexProviderInterface::class, function(Application $app) {
            return new AddReviewIndexDataProvider($app->make(ElasticsearchClient::class));
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
