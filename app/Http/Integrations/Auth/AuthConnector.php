<?php

declare(strict_types=1);

namespace App\Http\Integrations\Auth;

use App\Data\Auth\Response\ApiResponseDtoData;
use Saloon\Http\Connector;
use Saloon\Http\Response;
use Saloon\Traits\Plugins\AcceptsJson;

final class AuthConnector extends Connector
{
    use AcceptsJson;

    public function resolveBaseUrl(): string
    {
        return config('services.backend.base_url').'/api/v1';
    }

    protected function defaultHeaders(): array
    {
        return [
            'Content-Type' => 'application/json',
            'X-Api-Key' => config('services.backend.api_key'),
            'User-Agent' => config('services.backend.user_agent'),
        ];
    }

    protected function defaultConfig(): array
    {
        return [
            'timeout' => 5,
            'verify' => false,
        ];
    }

    public function createDtoFromResponse(Response $response): ApiResponseDtoData
    {
        $data = $response->json();

        return new ApiResponseDtoData(
            success: $data['success'],
            message: $data['message'] ?? '',
            data: $data['data'] ?? null,
            meta: $data['meta'] ?? null,
            error: $data['error'] ?? null,
            errors: $data['errors'] ?? null,
        );
    }
}
