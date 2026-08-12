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
        abort_if($user->isSuperAdmin(), 422, 'Uloga glavnog administratora se ne može mijenjati.');

        $data = $request->validate([
            'role' => ['required', Rule::in([User::ROLE_MEMBER, User::ROLE_ADMIN])],
        ]);

        $user->update($data);

        return redirect()
            ->route('admin.users.index')
            ->with('status', $user->role === User::ROLE_ADMIN
                ? 'Korisniku je odobreno objavljivanje.'
                : 'Administratorsko ovlaštenje je uklonjeno.');
    }
}
