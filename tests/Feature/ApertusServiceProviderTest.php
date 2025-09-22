<?php

namespace Mmorand\Apertus\Tests\Feature;

use Mmorand\Apertus\Apertus;
use Mmorand\Apertus\Facades\Apertus as ApertusFacade;
use Mmorand\Apertus\Resources\Chat;
use Mmorand\Apertus\Resources\Models;
use Mmorand\Apertus\Tests\TestCase;
use Mockery;

class ApertusServiceProviderTest extends TestCase
{
    public function test_apertus_is_bound_in_container(): void
    {
        $this->assertTrue($this->app->bound(Apertus::class));
    }

    public function test_apertus_resolves_with_config_values(): void
    {
        $apertus = app(Apertus::class);

        $this->assertInstanceOf(Apertus::class, $apertus);

        $this->assertEquals('https://api.apertus.ai', $apertus->resolveBaseUrl());
        $this->assertEquals('Apertus-PHP/1.0.0', $apertus->getUserAgent());
        $this->assertEquals(120, $apertus->getConnectTimeout());
    }

    public function test_service_provider_binding(): void
    {
        $apertus = app(Apertus::class);
        $this->assertInstanceOf(Apertus::class, $apertus);
    }

    public function test_facade_resolves(): void
    {
        $apertus = ApertusFacade::getFacadeRoot();
        $this->assertInstanceOf(Apertus::class, $apertus);
    }

    public function test_facade_methods_works(): void
    {
        $chat = ApertusFacade::chat();
        $models = ApertusFacade::models();

        $this->assertInstanceOf(Chat::class, $chat);
        $this->assertInstanceOf(Models::class, $models);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}
