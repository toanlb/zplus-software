<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class LanguageController extends Controller
{
    /**
     * Switch the application language
     *
     * @param string $locale
     * @return \Illuminate\Http\RedirectResponse
     */
    public function switch($locale)
    {
        // Check if the locale is supported
        if (!in_array($locale, ['en', 'vi'])) {
            $locale = 'en'; // Default to English if not supported
        }
        
        // Store the locale in the session
        Session::put('locale', $locale);
        
        // Set the application locale
        App::setLocale($locale);
        
        // Redirect back to the previous page
        return redirect()->back();
    }
}