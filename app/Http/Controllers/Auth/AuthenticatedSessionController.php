<?php

namespace App\Http\Controllers\Auth;

use Exception;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Integrations\Auth\AuthConnector;
use App\Http\Integrations\Auth\Requests\AuthLogoutRequest;

class AuthenticatedSessionController extends Controller
{

    public function __construct(protected AuthConnector $authConnector) {}

    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        return redirect()->intended(route('dashboard', absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {

        $logoutRequest = new AuthLogoutRequest();

        $this->authConnector->send($logoutRequest);

        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
