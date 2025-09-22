<?php

namespace Mmorand\Apertus\Tests\Feature;

use JsonException;
use Mmorand\Apertus\Apertus;
use Mmorand\Apertus\Tests\TestCase;
use Saloon\Exceptions\Request\FatalRequestException;
use Saloon\Exceptions\Request\RequestException;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;

class ModelsTest extends TestCase
{
    /**
     * @throws FatalRequestException
     * @throws RequestException
     */
    public function test_models_list_returns_models(): void
    {
        $mockClient = new MockClient([
            MockResponse::make([
                'object' => 'list',
                'data' => [
                    [
                        'id' => 'swiss-ai/apertus-8b-instruct-key',
                        'object' => 'swiss-ai/apertus-8b-instruct',
                        'created' => 1699017600,
                        'owned_by' => 'swiss-ai',
                    ],
                    [
                        'id' => 'swiss-ai/apertus-70b-instruct-key',
                        'object' => 'swiss-ai/apertus-70b-instruct',
                        'created' => 1699104000,
                        'owned_by' => 'swiss-ai',
                    ],
                ],
            ]),
        ]);

        $apertus = app(Apertus::class);
        $apertus->withMockClient($mockClient);

        $response = $apertus->models()->list();

        $this->assertTrue($response->successful());

        $dto = $response->dto();
        $this->assertEquals('list', $dto->object);
        $this->assertCount(2, $dto->data);

        $firstModel = $dto->data[0];
        $this->assertEquals('swiss-ai/apertus-8b-instruct-key', $firstModel->id);
        $this->assertEquals('swiss-ai/apertus-8b-instruct', $firstModel->object->value);
        $this->assertEquals('swiss-ai', $firstModel->ownedBy);
    }

    /**
     * @throws FatalRequestException
     * @throws RequestException
     */
    public function test_models_list_handles_empty_response(): void
    {
        $mockClient = new MockClient([
            MockResponse::make([
                'object' => 'list',
                'data' => [],
            ]),
        ]);

        $apertus = app(Apertus::class);
        $apertus->withMockClient($mockClient);

        $response = $apertus->models()->list();

        $this->assertTrue($response->successful());

        $dto = $response->dto();
        $this->assertEquals('list', $dto->object);
        $this->assertCount(0, $dto->data);
    }

    /**
     * @throws FatalRequestException
     * @throws RequestException
     * @throws JsonException
     */
    public function test_models_list_handles_api_error(): void
    {
        $mockClient = new MockClient([
            MockResponse::make([
                'error' => [
                    'message' => 'Unauthorized',
                    'type' => 'invalid_request_error',
                    'code' => 'invalid_api_key',
                ],
            ], 401),
        ]);

        $apertus = app(Apertus::class);
        $apertus->withMockClient($mockClient);

        $response = $apertus->models()->list();

        $this->assertFalse($response->successful());
        $this->assertEquals(401, $response->status());

        $errorData = $response->json();
        $this->assertEquals('Unauthorized', $errorData['error']['message']);
    }
}
