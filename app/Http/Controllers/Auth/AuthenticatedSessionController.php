<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        session()->forget('login_attempts');
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): \Illuminate\Http\RedirectResponse
    {
         // Ambil jumlah percobaan sebelumnya dari session
    $attempts = session('login_attempts', 0);

    // Ambil data login
    $credentials = $request->only('email', 'password');
    $remember = $request->boolean('remember');

    // Coba autentikasi manual, tanpa throw exception dulu
    if (!Auth::attempt($credentials, $remember)) {
        $attempts++;
        session(['login_attempts' => $attempts]);
        session()->save(); // Penting: commit langsung ke DB

        // Lempar exception manual agar pesan error tetap tampil
        throw ValidationException::withMessages([
            'email' => __('These credentials do not match our records.'),
        ]);
    }

    // Jika berhasil login
    session(['login_attempts' => 0]);
    session()->save(); // reset counter di DB

    $request->session()->regenerate();

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
