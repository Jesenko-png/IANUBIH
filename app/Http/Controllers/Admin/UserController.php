<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class UserController extends Controller
{
    public function index(): View
    {
        $users = User::query()
            ->latest()
            ->paginate(20);

        return view('admin.users.index', compact('users'));
    }

    public function update(Request $request, User $user): RedirectResponse
    {
        abort_if($request->user()->is($user), 422, __('admin.users.cannot_change_self'));

        $data = $request->validate([
            'role' => ['required', Rule::in([
                User::ROLE_MEMBER,
                User::ROLE_ADMIN,
                User::ROLE_SUPER_ADMIN,
            ])],
        ]);

        $user->update($data);

        return redirect()
            ->route('admin.users.index')
            ->with('status', match ($user->role) {
                User::ROLE_SUPER_ADMIN => __('admin.users.promoted_super'),
                User::ROLE_ADMIN => __('admin.users.permission_granted'),
                default => __('admin.users.permission_removed'),
            });
    }
}
