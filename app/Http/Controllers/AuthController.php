<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
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
            || $request->query('plan') === 'ultra';
            
        return view('auth.auth-page', [
            'showRegister' => $showRegister,
            'selectedPlan' => $request->query('plan')
        ]);
    }

    /**
     * Handle login request - redirect to standard Laravel login
     */
    public function login(Request $request)
    {
        // Redirect to standard Laravel authentication
        return redirect()->route('login');
    }

    /**
     * Handle registration request - redirect to standard Laravel register
     */
    public function register(Request $request)
    {
        // Redirect to standard Laravel registration
        return redirect()->route('register');
    }
}
