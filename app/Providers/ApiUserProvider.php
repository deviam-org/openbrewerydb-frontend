<?php

declare(strict_types=1);

namespace App\Providers;

use App\Http\Integrations\Auth\AuthConnector;
use App\Http\Integrations\Auth\Requests\AuthLoginRequest;
use App\Http\Integrations\Auth\Requests\AuthProfileRequest;
use Illuminate\Auth\GenericUser;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Support\Facades\Session;
use Saloon\Http\Auth\TokenAuthenticator;

class ApiUserProvider implements UserProvider
{
    public function __construct(
        protected readonly AuthConnector $authConnector
    ) {}

    public function retrieveByCredentials(array $credentials): ?Authenticatable
    {
        if (! array_key_exists('email', $credentials) || ! array_key_exists('password', $credentials)) {
            return null;
        }

        $clientRequest = new AuthLoginRequest(
            email: $credentials['email'],
            password: $credentials['password'],
        );

        $response = $this->authConnector->send($clientRequest);

        if ($response->successful()) {

            $responseDto = $response->dtoOrFail();

            Session::put('access_token', $responseDto['access_token']);
            Session::put('refresh_token', $responseDto['refresh_token']);

            return new GenericUser($this->getAuthUser($responseDto['access_token']));
        }

        return null;
    }

    public function validateCredentials(Authenticatable $user, array $credentials): bool
    {
        return (bool) $user;
    }

    public function retrieveById($identifier): ?Authenticatable
    {
        $user = null;

        if (Session::exists('user')) {
            $user = Session::get('user');
        } else {
            Session::invalidate();
        }

        if ($user && $user['id'] === $identifier) {
            return new GenericUser($user);
        }

        return null;
    }

    public function retrieveByToken($identifier, $token): void {}

    public function updateRememberToken(Authenticatable $user, $token): void {}

    private function getAuthUser($token): array
    {
        $clientRequest = new AuthProfileRequest;
        $this->authConnector->authenticate(new TokenAuthenticator($token));
        $response = $this->authConnector->send($clientRequest);

        if ($response->successful()) {

            $responseDto = $response->dtoOrFail();

            $user = $responseDto->data;
            $user['remember_token'] = null;

            Session::put('user', $user);

            return $user;
        }

        return [];
    }

    public function rehashPasswordIfRequired(Authenticatable $user, #[\SensitiveParameter] array $credentials, bool $force = false): void {}
}
