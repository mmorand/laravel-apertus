<?php

namespace Mmorand\Apertus\Tests;

use Dotenv\Dotenv;
use Mmorand\Apertus\ApertusServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;
use Saloon\Http\Senders\GuzzleSender;
use Saloon\Laravel\SaloonServiceProvider;
use Spatie\LaravelData\LaravelDataServiceProvider;

class TestCase extends Orchestra
{
    protected function getPackageProviders($app): array
    {
        return [
            ApertusServiceProvider::class,
            LaravelDataServiceProvider::class,
            SaloonServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app): void
    {
        if (file_exists(dirname(__DIR__).'/.env')) {
            (Dotenv::createImmutable(dirname(__DIR__), '.env'))->load();
        }

        config()->set('apertus.api_key', env('APERTUS_API_KEY', 'sdk-api-key-test'));
        config()->set('apertus.base_url', env('APERTUS_BASE_URL', 'https://api.apertus.ai'));
        config()->set('apertus.user_agent', env('APERTUS_USER_AGENT', 'Apertus-PHP/1.0.0'));
        config()->set('apertus.timeout', 120);

        config()->set('saloon.default_sender', GuzzleSender::class);

        config()->set('data.max_transformation_depth', 10);
        config()->set('data.throw_when_max_depth_reached', true);

    }
}
