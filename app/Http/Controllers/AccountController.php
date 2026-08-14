<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class AccountController extends Controller
{
    public function show(Request $request): View
    {
        $locale = $request->string('locale')->toString();

        if (! in_array($locale, ['bs', 'en'], true)) {
            $locale = $request->session()->get('locale', 'bs');
        }

        $locale = in_array($locale, ['bs', 'en'], true) ? $locale : 'bs';

        app()->setLocale($locale);
        $request->session()->put('locale', $locale);

        return view('account.show');
    }
}
