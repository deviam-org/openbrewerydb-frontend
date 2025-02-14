<?php

declare(strict_types=1);

namespace App\Http\Integrations\Auth\Requests;

use Saloon\Enums\Method;
use Saloon\Http\Request;

final class AuthProfileRequest extends Request
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return '/auth/profile';
    }
}
