@extends('layouts.admin')

@section('title', __('account.my_account'))

@section('content')
<div class="admin-page-heading">
    <div>
        <span class="admin-eyebrow">{{ __('account.user_account') }}</span>
        <h1>{{ auth()->user()->name }}</h1>
        <p>{{ auth()->user()->email }}</p>
    </div>
    @if (auth()->user()->canManageNews())
        <a href="{{ route('admin.news.index') }}" class="admin-button admin-button-primary">{{ __('account.open_news') }}</a>
    @endif
</div>

<section class="admin-panel account-status-card">
    @if (auth()->user()->isSuperAdmin())
        <span class="account-role account-role-super">{{ __('account.roles.super_admin') }}</span>
        <h2>{{ __('account.super_admin.heading') }}</h2>
        <p>{{ __('account.super_admin.description') }}</p>
        <a href="{{ route('admin.users.index') }}" class="admin-button admin-button-secondary">{{ __('account.manage_users') }}</a>
    @elseif (auth()->user()->canManageNews())
        <span class="account-role account-role-admin">{{ __('account.roles.admin') }}</span>
        <h2>{{ __('account.admin.heading') }}</h2>
        <p>{{ __('account.admin.description') }}</p>
        <a href="{{ route('admin.news.index') }}" class="admin-button admin-button-secondary">{{ __('account.open_cms') }}</a>
    @else
        <span class="account-role account-role-member">{{ __('account.roles.member') }}</span>
        <h2>{{ __('account.member.heading') }}</h2>
        <p>{{ __('account.member.description') }}</p>
    @endif
</section>

<section class="admin-panel account-password-card" aria-labelledby="account-password-title">
    <h2 id="account-password-title">{{ __('account.password.heading') }}</h2>
    <p>{{ __('account.password.intro') }}</p>

    <form method="POST" action="{{ route('account.password.update') }}" class="admin-form">
        @csrf
        @method('PUT')
        <input type="hidden" name="locale" value="{{ app()->getLocale() }}">
        <div class="form-field">
            <label for="current_password">{{ __('account.password.current') }}</label>
            <input id="current_password" type="password" name="current_password" autocomplete="current-password" required>
        </div>
        <div class="form-field">
            <label for="password">{{ __('account.password.new') }}</label>
            <input id="password" type="password" name="password" autocomplete="new-password" required>
            <small class="field-help">{{ __('auth.password_help') }}</small>
        </div>
        <div class="form-field">
            <label for="password_confirmation">{{ __('account.password.confirm') }}</label>
            <input id="password_confirmation" type="password" name="password_confirmation" autocomplete="new-password" required>
        </div>
        <button type="submit" class="admin-button admin-button-primary">{{ __('account.password.save') }}</button>
    </form>
</section>
@endsection
