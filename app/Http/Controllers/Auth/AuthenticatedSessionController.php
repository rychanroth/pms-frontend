<?php

namespace App\Http\Controllers\Auth;

use App\Services\DjangoApiService;
use App\Models\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\View\View;
use Illuminate\Validation\ValidationException;

class AuthenticatedSessionController extends Controller
{
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
        $django = new DjangoApiService();
        $response = $django->login($request->username, $request->password);

        if ($response->failed()) {
            throw ValidationException::withMessages([
                'username' => trans('auth.failed'),
            ]);
        }

        $data = $response->json();

        $user = User::firstOrCreate([
            'email' => $data['username'] . '@ghost.local'
        ], [
            'name' => $data['username'],
            'password' => bcrypt('ghost_password')
        ]);

        Auth::login($user);
        session()->put('api_token', $data['token']);

        $meResponse = Http::withHeaders([
            'Authorization' => 'Token ' . $data['token']
        ])->get("{$django->baseUrl}/users/me/");

        if ($meResponse->successful()) {
            session()->put('user_role', $meResponse->json('role'));
        }

        return redirect()->intended(route('dashboard', absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
