<?php

declare(strict_types=1);

namespace App\Http\Integrations\Auth\Requests;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\Traits\Body\HasJsonBody;

final class AuthLoginRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    public function resolveEndpoint(): string
    {
        return '/auth/login';
    }

    public function __construct(
        protected string $email,
        protected string $password,
    ) {}

    protected function defaultBody(): array
    {
        return [
            'email' => $this->email,
            'password' => $this->password,
        ];
    }

    public function createDtoFromResponse(Response $response): array
    {
        return $response->json('data');
    }
}
