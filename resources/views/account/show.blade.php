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
@endsection
