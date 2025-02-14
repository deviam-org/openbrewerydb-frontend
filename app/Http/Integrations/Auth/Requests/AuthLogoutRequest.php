<?php

declare(strict_types=1);

namespace App\Http\Integrations\Auth\Requests;

use Saloon\Enums\Method;
use Saloon\Http\Request;

final class AuthLogoutRequest extends Request
{
    protected Method $method = Method::POST;

    /**
     * Default headers for every request
     */
    protected function defaultHeaders(): array
    {
        return [
            'Content-Type' => 'application/json',
            'X-Api-Key' => config('services.backend.api_key'),
            'User-Agent' => config('services.backend.user-agent'),
            'Authorization' => 'Bearer ' . session('access_token'),
        ];
    }

    public function resolveEndpoint(): string
    {
        return '/auth/logout';
    }
}
