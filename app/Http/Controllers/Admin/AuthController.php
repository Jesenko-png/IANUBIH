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
    public function create(): View
    {
        return view('admin.auth.login');
    }

    public function store(Request $request): RedirectResponse
    {
        $credentials = $request->validateWithBag('login', [
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (! Auth::attempt($credentials, $request->boolean('remember'))) {
            $exception = ValidationException::withMessages([
                'email' => 'Uneseni podaci nisu ispravni.',
            ]);
            $exception->errorBag = 'login';

            throw $exception;
        }

        $request->session()->regenerate();

        if ($request->user()->canManageNews()) {
            return redirect()->intended(route('admin.news.index'));
        }

        return redirect()->route('account.show');
    }

    public function register(Request $request): RedirectResponse
    {
        $data = $request->validateWithBag('register', [
            'name' => ['required', 'string', 'max:255'],
            'register_email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'register_password' => [
                'required',
                'confirmed',
                Password::min(10)->letters()->numbers(),
            ],
        ], [], [
            'name' => 'ime i prezime',
            'register_email' => 'email',
            'register_password' => 'lozinka',
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
                ->with('status', 'Kreiran je prvi nalog s ovlaštenjima glavnog administratora.');
        }

        return redirect()
            ->route('account.show')
            ->with('status', 'Nalog je kreiran. Glavni administrator mora odobriti pravo objavljivanja.');
    }

    public function destroy(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
