<?php

namespace App\Http\Controllers;

use App;

class LocalizationController extends Controller
{
    public function switchLang($locale)
    {
        if (!in_array($locale, ['tw', 'en'])) {
            $locale = 'tw';
        }
        App::setLocale($locale);
        session()->put('locale', $locale);
        return redirect()->back();
    }
}
