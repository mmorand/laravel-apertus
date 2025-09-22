<?php

namespace Mmorand\Apertus\Tests\Feature;

use Mmorand\Apertus\Tests\TestCase;
use Mockery;

class ApertusCommandTest extends TestCase
{
    public function test_models_command_works(): void
    {
        $mockResponse = Mockery::mock();
        $mockResponse->shouldReceive('dto')->andReturn((object) [
            'data' => [
                (object) ['id' => 'swiss-ai/apertus-8b-instruct', 'object' => 'model'],
            ],
        ]);

        $mockModels = Mockery::mock();
        $mockModels->shouldReceive('list')->andReturn($mockResponse);

        $mockApertus = Mockery::mock();
        $mockApertus->shouldReceive('models')->andReturn($mockModels);

        $this->app->instance('apertus', $mockApertus);

        $this->artisan('apertus:models')
            ->expectsOutput('Available models:')
            ->assertExitCode(0);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}
