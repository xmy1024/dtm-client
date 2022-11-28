<?php

declare(strict_types=1);
/**
 * This file is part of DTM-PHP.
 *
 * @license  https://github.com/dtm-php/dtm-client/blob/master/LICENSE
 */
namespace DtmClient;

use DtmClient\Api\ApiInterface;
use DtmClient\Api\HttpApi;
use DtmClient\Api\HttpApiFactory;
use DtmClient\Config\DatabaseConfigInterface;
use DtmClient\DBSpecial\DBSpecialFactory;
use DtmClient\DBSpecial\DBSpecialInterface;
use DtmClient\DbTransaction\DBTransactionInterface;
use DtmClient\DbTransaction\LaravelDbTransaction;
use DtmClient\Grpc\GrpcClientManager;
use DtmClient\Grpc\GrpcClientManagerFactory;
use DtmClient\JsonRpc\DtmPathGenerator;
use Illuminate\Foundation\Application as LaravelApplication;
use Illuminate\Foundation\ProviderRepository;
use Illuminate\Support\ServiceProvider as LaravelServiceProvider;
use Psr\Http\Message\ResponseInterface;

/**
 * Class ServiceProvider.
 */
class LaravelProvider extends LaravelServiceProvider
{
    /**
     * Boot the provider.
     */
    public function boot()
    {
    }

    /**
     * Register the provider.
     */
    public function register()
    {
        $this->setupConfig();

        return [
            HttpApi::class => HttpApiFactory::class,
            BranchIdGeneratorInterface::class => BranchIdGenerator::class,
            ApiInterface::class => ApiFactory::class,
            GrpcClientManager::class => GrpcClientManagerFactory::class,
            DBTransactionInterface::class => LaravelDbTransaction::class,
            DBSpecialInterface::class => DBSpecialFactory::class,
            PathGeneratorInterface::class => DtmPathGenerator::class,
            JsonRpcTransporter::class => JsonRpcPoolTransporter::class,
            ResponseInterface::class => Response::class,
        ];
    }

    /**
     * Setup the config.
     */
    protected function setupConfig()
    {
        $source = realpath(__DIR__ . '/../publish/dtm.php');

        if ($this->app instanceof LaravelApplication && $this->app->runningInConsole()) {
            $this->publishes([$source => config_path('dtm.php')], 'dtm');
        }

        $this->mergeConfigFrom($source, 'dtm');
    }

}
