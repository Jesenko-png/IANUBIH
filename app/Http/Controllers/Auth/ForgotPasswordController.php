<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\View\View;
use Throwable;

class ForgotPasswordController extends Controller
{
    public function create(Request $request): View
    {
        $this->setLocale($request);

        return view('auth.forgot-password');
    }

    public function store(Request $request): RedirectResponse
    {
        $this->setLocale($request);

        $request->validate([
            'email' => ['required', 'email'],
        ]);

        try {
            Password::sendResetLink($request->only('email'));
        } catch (Throwable $exception) {
            report($exception);

            return back()
                ->withInput($request->only('email', 'locale'))
                ->withErrors(['email' => __('auth.reset_unavailable')]);
        }

        return back()->with('status', __('auth.reset_request_sent'));
    }

    private function setLocale(Request $request): void
    {
        $locale = $request->string('locale')->toString();

        if (! in_array($locale, ['bs', 'en'], true)) {
            $locale = $request->session()->get('locale', 'bs');
        }

        $locale = in_array($locale, ['bs', 'en'], true) ? $locale : 'bs';

        app()->setLocale($locale);
        $request->session()->put('locale', $locale);
    }
}
