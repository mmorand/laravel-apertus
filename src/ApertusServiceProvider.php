<?php

namespace Mmorand\Apertus;

use Mmorand\Apertus\Commands\ApertusCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class ApertusServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('apertus')
            ->hasConfigFile()
            ->hasCommand(ApertusCommand::class);
    }

    public function packageBooted(): void
    {
        $this->app->bind(Apertus::class, function () {
            return new Apertus(
                apiKey: config('apertus.api_key'),
                baseUrl: config('apertus.base_url'),
                userAgent: config('apertus.user_agent'),
                timeout: config('apertus.timeout', 60),
            );
        });
    }
}
