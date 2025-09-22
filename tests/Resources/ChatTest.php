<?php

namespace Mmorand\Apertus\Tests\Feature;

use Mmorand\Apertus\Apertus;
use Mmorand\Apertus\Enums\Model;
use Mmorand\Apertus\Tests\TestCase;
use Saloon\Exceptions\Request\FatalRequestException;
use Saloon\Exceptions\Request\RequestException;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;

class ChatTest extends TestCase
{
    /**
     * @throws FatalRequestException
     * @throws RequestException
     */
    public function test_chat_create_sends_correct_request(): void
    {
        $mockClient = new MockClient([
            MockResponse::make([
                'id' => 'chatcmpl-test',
                'object' => 'chat.completion',
                'created' => time(),
                'model' => 'swiss-ai/apertus-8b-instruct',
                'choices' => [
                    [
                        'index' => 0,
                        'message' => [
                            'role' => 'assistant',
                            'content' => 'Hello from test!',
                        ],
                        'finish_reason' => 'stop',
                    ],
                ],
                'usage' => [
                    'prompt_tokens' => 10,
                    'completion_tokens' => 5,
                    'total_tokens' => 15,
                ],
            ]),
        ]);

        $apertus = app(Apertus::class);
        $apertus->withMockClient($mockClient);

        $response = $apertus->chat()->create(
            model: Model::apertus8b,
            messages: [
                ['role' => 'user', 'content' => 'Hello!'],
            ],
            maxTokens: 100
        );

        $this->assertTrue($response->successful());
        $dto = $response->dto();
        $this->assertEquals('Hello from test!', $dto->choices[0]->message->content);

        $mockClient->assertSent(function ($request) {
            $data = $request->body()->get();

            return $data['model'] === 'swiss-ai/apertus-8b-instruct'
                && $data['messages'][0]['content'] === 'Hello!'
                && $data['max_tokens'] === 100;
        });
    }

    /**
     * @throws FatalRequestException
     * @throws RequestException
     */
    public function test_chat_with_tool_calls(): void
    {
        $mockClient = new MockClient([
            MockResponse::make([
                'id' => 'chatcmpl-tool-test',
                'object' => 'chat.completion',
                'created' => time(),
                'model' => 'swiss-ai/apertus-8b-instruct',
                'choices' => [
                    [
                        'index' => 0,
                        'message' => [
                            'role' => 'assistant',
                            'content' => '',
                            'tool_calls' => [
                                [
                                    'id' => 'call_abc123',
                                    'type' => 'function',
                                    'function' => [
                                        'name' => 'get_weather',
                                        'type' => 'object',
                                        'description' => 'Get current weather in a location',
                                        'parameters' => [
                                            'location' => 'Paris',
                                            'unit' => 'celsius',
                                        ],
                                    ],
                                ],
                            ],
                        ],
                        'finish_reason' => 'tool_calls',
                    ],
                ],
                'usage' => [
                    'prompt_tokens' => 50,
                    'completion_tokens' => 20,
                    'total_tokens' => 70,
                ],
            ]),
        ]);

        $apertus = app(Apertus::class);
        $apertus->withMockClient($mockClient);

        $response = $apertus->chat()->create(
            model: Model::apertus8b,
            messages: [
                [
                    'role' => 'user',
                    'content' => 'What is the weather in Paris?',
                ],
            ],
            tools: [
                [
                    'type' => 'function',
                    'function' => [
                        'name' => 'get_weather',
                        'description' => 'Get current weather in a location',
                        'parameters' => [
                            'type' => 'object',
                            'parameters' => [
                                'location' => [
                                    'type' => 'string',
                                    'description' => 'City name',
                                ],
                                'unit' => [
                                    'type' => 'string',
                                    'enum' => ['celsius', 'fahrenheit'],
                                ],
                            ],
                            'required' => ['location'],
                        ],
                    ],
                ],
            ],
            toolChoice: 'auto'
        );

        $this->assertTrue($response->successful());

        $dto = $response->dto();

        $message = $dto->choices[0]->message;
        $this->assertEquals('', $message->content);
        $this->assertNotNull($message->toolCalls);
        $this->assertCount(1, $message->toolCalls);

        $toolCall = $message->toolCalls[0];
        $this->assertEquals('call_abc123', $toolCall->id);
        $this->assertEquals('function', $toolCall->type);
        $this->assertEquals('get_weather', $toolCall->function->name);
        $this->assertEquals('Get current weather in a location', $toolCall->function->description);

        $args = $toolCall->function->parameters;
        $this->assertEquals('Paris', $args['location']);
        $this->assertEquals('celsius', $args['unit']);
    }

    /**
     * @throws FatalRequestException
     * @throws RequestException
     */
    public function test_chat_handles_api_error(): void
    {
        $mockClient = new MockClient([
            MockResponse::make(['error' => ['message' => 'API Error']], 400),
        ]);

        $apertus = app(Apertus::class);
        $apertus->withMockClient($mockClient);

        $response = $apertus->chat()->create(
            model: Model::apertus8b,
            messages: [['role' => 'user', 'content' => 'Test']]
        );

        $this->assertFalse($response->successful());
        $this->assertEquals(400, $response->status());
    }
}
