<?php

namespace EthicalJobs\Foundation\Laravel;

use Elasticsearch\Client;
use Elasticsearch\ClientBuilder;
use Illuminate\Support\ServiceProvider;
use EthicalJobs\Foundation\Elasticsearch\Index;
use EthicalJobs\Foundation\Elasticsearch\IndexSettings;

/**
 * Elasticsearch service provider
 *
 * @author Andrew McLagan <andrew@ethicaljobs.com.au>
 */
class ElasticsearchServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Config file path
     *
     * @var string
     */
    protected $configPath = __DIR__.'/../../config/elasticsearch.php';


    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([$this->configPath => config_path('elasticsearch.php')]);
    }

     /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom($this->configPath, 'elasticsearch');        

        $this->registerConnectionSingleton();

        $this->registerIndexSingleton();
    }

    /**
     * Register connection instance
     *
     * @return void
     */
    public function registerConnectionSingleton()
    {
        $this->app->singleton(Client::class, function () {

            $defaultConfig = [
                'logPath'   => storage_path().'/logs/elasticsearch-'.php_sapi_name().'.log',
            ];

            $config = array_merge($defaultConfig, config('elasticsearch'));

            $connection = array_get($config, 'connections.'.$config['defaultConnection']);

            $client = ClientBuilder::create()->setHosts($connection['hosts']);

            if ($connection['logging']) {
                $logger = ClientBuilder::defaultLogger($connection['logPath']);
                $client->setLogger($logger);
            }

            return $client->build();
        });
    }

     /**
     * Register index instance
     *
     * @return void
     */
    public function registerIndexSingleton()
    {
        $this->app->singleton(Index::class, function ($app) {

            $settings = new IndexSettings(
                config('elasticsearch.index'),
                config('elasticsearch.settings'),
                config('elasticsearch.mappings')
            );

            $settings->setIndexables(config('elasticsearch.indexables'));

            return new Index($app[Client::class], $settings);
        });
    }    

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            Client::class,
            Index::class,
        ];
    }
}