<?php

namespace App\Http\Integrations\BackendConnector;

use App\Data\Auth\Response\ApiResponseDtoData;
use Saloon\Helpers\OAuth2\OAuthConfig;
use Saloon\Http\Connector;
use Saloon\Http\Response;
use Saloon\Traits\Plugins\AcceptsJson;
use Saloon\Traits\Plugins\AlwaysThrowOnErrors;
use Saloon\Traits\Plugins\HasTimeout;

class BackendConnector extends Connector
{
    use AcceptsJson;
    use AlwaysThrowOnErrors;

    use HasTimeout;

    /**
     * The Base URL of the API.
     */
    public function resolveBaseUrl(): string
    {
        return config('services.backend.base_url').'/api/v1';
    }

    /**
     * Default headers for every request
     */
    protected function defaultHeaders(): array
    {
        return [
            'Content-Type' => 'application/json',
            'X-Api-Key' => config('services.backend.api_key'),
            'User-Agent' => config('services.backend.user-agent'),
            'Authorization' => 'Bearer '.session('access_token'),
        ];
    }

    /**
     * Default HTTP client options
     */
    protected function defaultConfig(): array
    {
        return [
            'timeout' => 5,
            'verify' => false,
        ];
    }

    /**
     * Create a DTO from the response
     *
     *
     * @throws JsonException
     */
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
