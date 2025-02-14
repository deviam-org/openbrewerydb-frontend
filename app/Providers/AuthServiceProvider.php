<?php

declare(strict_types=1);

namespace App\Providers;

use App\Http\Integrations\Auth\AuthConnector;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Auth;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        Auth::provider('external_api', fn ($app, array $config) => new ApiUserProvider(new AuthConnector()));
    }
}
