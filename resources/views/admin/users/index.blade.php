@extends('layouts.admin')

@section('title', __('admin.users.title'))

@section('content')
<div class="admin-page-heading">
    <div>
        <span class="admin-eyebrow">{{ __('admin.users.eyebrow') }}</span>
        <h1>{{ __('admin.users.title') }}</h1>
        <p>{{ __('admin.users.intro') }}</p>
    </div>
</div>

<section class="admin-panel users-panel" aria-label="{{ __('admin.users.list_label') }}">
    <div class="permission-legend">
        <div><strong>{{ __('admin.users.member') }}</strong><span>{{ __('admin.users.member_description') }}</span></div>
        <div><strong>{{ __('admin.users.administrator') }}</strong><span>{{ __('admin.users.administrator_description') }}</span></div>
        <div><strong>{{ __('admin.users.super_administrator') }}</strong><span>{{ __('admin.users.super_administrator_description') }}</span></div>
    </div>

    <div class="user-list">
        @foreach ($users as $user)
            <article class="user-row">
                <div class="user-avatar" aria-hidden="true">{{ mb_strtoupper(mb_substr($user->name, 0, 1)) }}</div>
                <div class="user-identity">
                    <h2>{{ $user->name }}</h2>
                    <p>{{ $user->email }}</p>
                    <small>{{ __('admin.users.created', ['date' => $user->created_at->format('d.m.Y. H:i')]) }}</small>
                </div>

                @if ($user->isSuperAdmin())
                    <span class="account-role account-role-super">{{ __('admin.users.super_administrator') }}</span>
                @else
                    <form method="POST" action="{{ route('admin.users.update', $user) }}" class="user-role-form">
                        @csrf
                        @method('PATCH')
                        <label for="role-{{ $user->id }}">{{ __('admin.users.role') }}</label>
                        <select id="role-{{ $user->id }}" name="role">
                            <option value="member" @selected($user->role === 'member')>{{ __('admin.users.member') }}</option>
                            <option value="admin" @selected($user->role === 'admin')>{{ __('admin.users.administrator') }}</option>
                        </select>
                        <button type="submit" class="admin-button admin-button-primary">{{ __('admin.users.save_permission') }}</button>
                    </form>
                @endif
            </article>
        @endforeach
    </div>

    @if ($users->hasPages())
        <nav class="admin-pagination" aria-label="{{ __('admin.users.pages') }}">
            @if ($users->onFirstPage())
                <span>{{ __('admin.common.previous') }}</span>
            @else
                <a href="{{ $users->previousPageUrl() }}">{{ __('admin.common.previous') }}</a>
            @endif
            <strong>{{ $users->currentPage() }} / {{ $users->lastPage() }}</strong>
            @if ($users->hasMorePages())
                <a href="{{ $users->nextPageUrl() }}">{{ __('admin.common.next') }}</a>
            @else
                <span>{{ __('admin.common.next') }}</span>
            @endif
        </nav>
    @endif
</section>
@endsection
