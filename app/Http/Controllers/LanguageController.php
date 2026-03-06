<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LanguageController extends Controller
{
    /**
     * Switch application language
     */
    public function switch(Request $request)
    {
        $locale = $request->input('locale');
        
        // Validate locale
        $supportedLocales = ['id', 'en', 'es', 'tr'];
        if (!in_array($locale, $supportedLocales)) {
            return redirect()->back()->with('error', 'Language not supported');
        }

        // Update user preference if authenticated
        if (auth()->check()) {
            auth()->user()->update(['locale' => $locale]);
        }

        // Store in session for guest users
        session(['locale' => $locale]);

        return redirect()->back()->with('success', __('messages.language_changed'));
    }
}
