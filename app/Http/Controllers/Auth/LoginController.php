<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\ApplicationLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');
        $remember = $request->has('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            // Log activity
            ApplicationLog::create([
                'user_id' => Auth::id(),
                'action' => 'LOGIN',
                'description' => 'User login ke sistem',
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent()
            ]);

            // Redirect ke dashboard
            return redirect()->intended(route('dashboard'));
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        if (Auth::check()) {
            ApplicationLog::create([
                'user_id' => Auth::id(),
                'action' => 'LOGOUT',
                'description' => 'User logout dari sistem',
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent()
            ]);
        }

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}