<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password as PasswordRule;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class ResetPasswordController extends Controller
{
    public function create(Request $request, string $token): View
    {
        $this->setLocale($request);

        return view('auth.reset-password', [
            'token' => $token,
            'email' => $request->string('email')->toString(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $this->setLocale($request);

        $request->validate([
            'token' => ['required', 'string'],
            'email' => ['required', 'email'],
            'password' => [
                'required',
                'confirmed',
                PasswordRule::min(10)->letters()->numbers(),
            ],
        ], [], [
            'email' => __('auth.email'),
            'password' => __('auth.password'),
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password): void {
                $user->forceFill([
                    'password' => Hash::make($password),
                    'remember_token' => Str::random(60),
                ])->save();

                event(new PasswordReset($user));
            }
        );

        if ($status !== Password::PASSWORD_RESET) {
            throw ValidationException::withMessages([
                'email' => __('auth.reset_invalid'),
            ]);
        }

        return redirect()
            ->route('login', ['locale' => app()->getLocale()])
            ->with('status', __('auth.reset_success'));
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
