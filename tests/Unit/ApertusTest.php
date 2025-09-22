<?php

namespace Mmorand\Apertus\Tests\Unit;

use Mmorand\Apertus\Apertus;
use PHPUnit\Framework\TestCase;
use ReflectionClass;
use ReflectionException;
use Saloon\Http\Auth\TokenAuthenticator;

class ApertusTest extends TestCase
{
    /**
     * @throws ReflectionException
     */
    public function test_apertus_auth_is_configured(): void
    {
        $apertus = new Apertus(
            apiKey: 'test-secret-key',
            baseUrl: 'https://api.test.com',
            userAgent: 'test/1.0',
            timeout: 30
        );

        $reflection = new ReflectionClass($apertus);
        $method = $reflection->getMethod('defaultAuth');

        $auth = $method->invoke($apertus);

        $this->assertInstanceOf(TokenAuthenticator::class, $auth);
    }
}
