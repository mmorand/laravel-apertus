<?php

namespace Mmorand\Apertus;

use Mmorand\Apertus\Resources\Chat;
use Mmorand\Apertus\Resources\Models;
use Saloon\Http\Auth\TokenAuthenticator;
use Saloon\Http\Connector;
use Saloon\Traits\Plugins\AcceptsJson;
use Saloon\Traits\Plugins\HasTimeout;
use SensitiveParameter;

/**
 * Apertus AI API
 *
 * Chat Completion API
 */
class Apertus extends Connector
{
    use AcceptsJson;
    use HasTimeout;

    public function __construct(
        #[SensitiveParameter] protected readonly string $apiKey,
        protected readonly ?string $baseUrl,
        protected readonly ?string $userAgent,
        protected ?int $timeout,
    ) {}

    public function getConnectTimeout(): int
    {
        return $this->timeout ?? config('apertus.timeout');
    }

    public function getRequestTimeout(): int
    {
        return $this->timeout ?? config('apertus.timeout');
    }

    public function resolveBaseUrl(): string
    {
        return $this->baseUrl ?? config('apertus.base_url');
    }

    public function chat(): Chat
    {
        return new Chat($this);
    }

    public function models(): Models
    {
        return new Models($this);
    }

    public function getUserAgent(): string
    {
        return $this->userAgent ?? config('apertus.user_agent');
    }

    protected function defaultAuth(): TokenAuthenticator
    {
        return new TokenAuthenticator($this->apiKey);
    }
}
