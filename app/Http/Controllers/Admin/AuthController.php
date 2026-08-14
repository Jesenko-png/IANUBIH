<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function create(Request $request): View
    {
        $this->setLocale($request);

        return view('admin.auth.login');
    }

    public function store(Request $request): RedirectResponse
    {
        $this->setLocale($request);

        $credentials = $request->validateWithBag('login', [
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (! Auth::attempt($credentials, $request->boolean('remember'))) {
            $exception = ValidationException::withMessages([
                'email' => __('auth.failed'),
            ]);
            $exception->errorBag = 'login';

            throw $exception;
        }

        $request->session()->regenerate();

        if ($request->user()->canManageNews()) {
            return redirect()->intended(route('admin.news.index'));
        }

        return redirect()->route('account.show', ['locale' => app()->getLocale()]);
    }

    public function register(Request $request): RedirectResponse
    {
        $this->setLocale($request);

        $data = $request->validateWithBag('register', [
            'name' => ['required', 'string', 'max:255'],
            'register_email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'register_password' => [
                'required',
                'confirmed',
                Password::min(10)->letters()->numbers(),
            ],
        ], [], [
            'name' => __('auth.full_name'),
            'register_email' => __('auth.email'),
            'register_password' => __('auth.password'),
        ]);

        $user = DB::transaction(function () use ($data): User {
            $isFirstUser = User::query()->lockForUpdate()->doesntExist();

            return User::create([
                'name' => $data['name'],
                'email' => $data['register_email'],
                'password' => $data['register_password'],
                'role' => $isFirstUser ? User::ROLE_SUPER_ADMIN : User::ROLE_MEMBER,
            ]);
        });

        Auth::login($user);
        $request->session()->regenerate();

        if ($user->isSuperAdmin()) {
            return redirect()
                ->route('admin.news.index')
                ->with('status', __('auth.first_account_created'));
        }

        return redirect()
            ->route('account.show', ['locale' => app()->getLocale()])
            ->with('status', __('auth.account_created_pending'));
    }

    public function destroy(Request $request): RedirectResponse
    {
        $this->setLocale($request);
        $locale = app()->getLocale();

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login', ['locale' => $locale]);
    }

    private function setLocale(Request $request): void
    {
        $locale = $request->string('locale')->toString();

        $locale = in_array($locale, ['bs', 'en'], true) ? $locale : 'bs';

        app()->setLocale($locale);
        $request->session()->put('locale', $locale);
    }
}
