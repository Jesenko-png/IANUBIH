<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class AccountController extends Controller
{
    public function show(Request $request): View
    {
        $this->setLocale($request);

        return view('account.show');
    }

    public function updatePassword(Request $request): RedirectResponse
    {
        $this->setLocale($request);

        $data = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => [
                'required',
                'confirmed',
                'different:current_password',
                Password::min(10)->letters()->numbers(),
            ],
        ], [], [
            'current_password' => __('account.password.current'),
            'password' => __('account.password.new'),
        ]);

        $request->user()->forceFill([
            'password' => Hash::make($data['password']),
            'remember_token' => Str::random(60),
        ])->save();

        $request->session()->regenerate();

        return redirect()
            ->route('account.show', ['locale' => app()->getLocale()])
            ->with('status', __('account.password.changed'));
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
