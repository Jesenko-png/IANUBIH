@extends('layouts.app')

@section('title', __('pages.items.' . $page . '.title') . ' | IANUBIH')
@section('description', __('pages.items.' . $page . '.intro'))

@section('content')
<section class="inner-hero placeholder-hero" aria-labelledby="page-title">
    <div class="inner-hero-shade"></div>
    <div class="container inner-hero-content">
        <div class="row">
            <div class="col-md-9">
                <span class="section-eyebrow section-eyebrow-light">{{ __('pages.items.' . $page . '.eyebrow') }}</span>
                <h1 id="page-title">{{ __('pages.items.' . $page . '.title') }}</h1>
                <p>{{ __('pages.items.' . $page . '.intro') }}</p>
            </div>
        </div>
    </div>
</section>

<section class="ianubih-section placeholder-section">
    <div class="container">
        <div class="placeholder-card">
            <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
            <span class="section-eyebrow">{{ __('pages.status') }}</span>
            <p>{{ __('pages.notice') }}</p>
            <a href="{{ route('home', ['locale' => app()->getLocale()]) }}" class="btn btn-ianubih-primary">{{ __('pages.back_home') }}</a>
        </div>
    </div>
</section>
@endsection
