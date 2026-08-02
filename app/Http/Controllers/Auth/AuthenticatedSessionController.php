<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

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
        $request->authenticate();

        $request->session()->regenerate();

        // Redirect langsung berdasarkan role — jangan pakai intended()
        // karena intended() bisa nyantol ke session URL role lain sebelumnya
        $role = Auth::user()->role;

        return match ($role) {
            'guru'        => redirect()->route('dashboard.guru'),
            'siswa'       => redirect()->route('dashboard.siswa'),
            'orang_tua'   => redirect()->route('dashboard.orang_tua'),
            'super_admin' => redirect()->route('dashboard.super_admin'),
            default       => redirect()->route('dashboard'),
        };
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();
        $request->session()->forget('url.intended'); // hapus intended URL

        return redirect('/');
    }
}
