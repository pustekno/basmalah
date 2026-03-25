<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Events\Registered;
use App\Models\User;

class AuthController extends Controller
{
    /**
     * Show the combined auth page (login/register with slide animation)
     * Accepts query params: ?tab=register or ?register=true
     */
    public function showAuthPage(Request $request)
    {
        // Check if should show register form
        $showRegister = $request->query('tab') === 'register' 
            || $request->query('register') === 'true'
            || $request->query('plan') === 'pro'
            || $request->query('plan') === 'ultra'
            || $request->routeIs('register');
            
        return view('auth.auth-page', [
            'showRegister' => $showRegister,
            'selectedPlan' => $request->query('plan')
        ]);
    }

    /**
     * Handle login request
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Viewer diarahkan ke landing page "/"
            if (Auth::user()->hasRole('Viewer')) {
                return redirect('/');
            }

            return redirect()->intended(route('dashboard'));
        }

        return back()->withErrors([
            'email' => __('auth.failed'),
        ])->withInput($request->only('email'));
    }

    /**
     * Handle registration request
     */
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
        ]);

        // Fire the Registered event to trigger AssignDefaultRole listener
        event(new Registered($user));

        Auth::login($user);

        return redirect()->route('dashboard');
    }
}
