@extends('layouts.app')

@section('title', __('cooperation.meta.title'))
@section('description', __('cooperation.meta.description'))

@section('content')
<section class="inner-hero cooperation-page-hero" aria-labelledby="page-title">
    <div class="inner-hero-shade"></div>
    <div class="container inner-hero-content">
        <div class="row">
            <div class="col-md-9">
                <span class="section-eyebrow section-eyebrow-light">{{ __('cooperation.hero.eyebrow') }}</span>
                <h1 id="page-title">{{ __('cooperation.hero.title') }}</h1>
                <p>{{ __('cooperation.hero.text') }}</p>
                <div class="cooperation-hero-actions">
                    <a href="#cooperation-form" class="btn btn-ianubih-gold">{{ __('cooperation.hero.primary') }}</a>
                    <a href="#cooperation-models" class="btn btn-ianubih-light-outline">{{ __('cooperation.hero.secondary') }}</a>
                </div>
                <nav class="breadcrumbs" aria-label="Breadcrumb">
                    <a href="{{ route('home', ['locale' => app()->getLocale()]) }}">{{ __('cooperation.hero.home') }}</a>
                    <span aria-hidden="true">/</span>
                    <span aria-current="page">{{ __('cooperation.hero.current') }}</span>
                </nav>
            </div>
        </div>
    </div>
</section>

<section class="ianubih-section cooperation-intro" aria-labelledby="cooperation-intro-title">
    <div class="container">
        <div class="row cooperation-intro-row">
            <div class="col-md-5 wow fadeInUp">
                <span class="section-eyebrow">{{ __('cooperation.intro.eyebrow') }}</span>
                <h2 id="cooperation-intro-title">{{ __('cooperation.intro.title') }}</h2>
            </div>
            <div class="col-md-6 col-md-offset-1 wow fadeInUp" data-wow-delay="0.15s">
                <p class="lead-copy">{{ __('cooperation.intro.text_first') }}</p>
                <p>{{ __('cooperation.intro.text_second') }}</p>
                <blockquote class="institutional-quote">{{ __('cooperation.intro.highlight') }}</blockquote>
            </div>
        </div>
    </div>
</section>

<section class="ianubih-section cooperation-audiences" aria-labelledby="cooperation-audiences-title">
    <div class="container">
        <div class="section-heading section-heading-centered wow fadeInUp">
            <span class="section-eyebrow">{{ __('cooperation.audiences.eyebrow') }}</span>
            <h2 id="cooperation-audiences-title">{{ __('cooperation.audiences.title') }}</h2>
            <p>{{ __('cooperation.audiences.intro') }}</p>
        </div>

        <div class="cooperation-audience-grid">
            @foreach(__('cooperation.audiences.items') as $audience)
                <article class="cooperation-audience-card wow fadeInUp" data-wow-delay="{{ ($loop->index % 3) * 0.1 }}s">
                    <div class="cooperation-audience-icon"><i class="fa {{ $audience['icon'] }}" aria-hidden="true"></i></div>
                    <span>{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
                    <h3>{{ $audience['title'] }}</h3>
                    <p>{{ $audience['text'] }}</p>
                </article>
            @endforeach
        </div>
    </div>
</section>

<section id="cooperation-models" class="ianubih-section cooperation-models" aria-labelledby="cooperation-models-title">
    <div class="cooperation-constellation" aria-hidden="true">
        <span class="cooperation-orbit cooperation-orbit-one"></span>
        <span class="cooperation-orbit cooperation-orbit-two"></span>
        <span class="cooperation-node cooperation-node-one"></span>
        <span class="cooperation-node cooperation-node-two"></span>
        <span class="cooperation-node cooperation-node-three"></span>
        <span class="cooperation-node cooperation-node-four"></span>
    </div>
    <div class="container">
        <div class="row cooperation-models-row">
            <div class="col-md-4 wow fadeInUp">
                <span class="section-eyebrow section-eyebrow-light">{{ __('cooperation.models.eyebrow') }}</span>
                <h2 id="cooperation-models-title">{{ __('cooperation.models.title') }}</h2>
                <p>{{ __('cooperation.models.intro') }}</p>
            </div>
            <div class="col-md-7 col-md-offset-1">
                <div class="cooperation-model-list">
                    @foreach(__('cooperation.models.items') as $model)
                        <article class="cooperation-model-item wow fadeInUp" data-wow-delay="{{ ($loop->index % 3) * 0.1 }}s">
                            <i class="fa {{ $model['icon'] }}" aria-hidden="true"></i>
                            <div>
                                <h3>{{ $model['title'] }}</h3>
                                <p>{{ $model['text'] }}</p>
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>

<section class="ianubih-section cooperation-process" aria-labelledby="cooperation-process-title">
    <div class="container">
        <div class="section-heading wow fadeInUp">
            <span class="section-eyebrow">{{ __('cooperation.process.eyebrow') }}</span>
            <h2 id="cooperation-process-title">{{ __('cooperation.process.title') }}</h2>
            <p>{{ __('cooperation.process.intro') }}</p>
        </div>

        <div class="cooperation-process-grid">
            @foreach(__('cooperation.process.items') as $step)
                <article class="cooperation-process-step wow fadeInUp" data-wow-delay="{{ $loop->index * 0.1 }}s">
                    <span>{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
                    <h3>{{ $step['title'] }}</h3>
                    <p>{{ $step['text'] }}</p>
                </article>
            @endforeach
        </div>
    </div>
</section>

<section id="cooperation-form" class="ianubih-section cooperation-inquiry" aria-labelledby="cooperation-form-title">
    <div class="container">
        <div class="cooperation-inquiry-grid">
            <div class="cooperation-contact-panel wow fadeInUp">
                <span class="section-eyebrow section-eyebrow-light">{{ __('cooperation.contact.eyebrow') }}</span>
                <h2>{{ __('cooperation.contact.title') }}</h2>
                <p>{{ __('cooperation.contact.text') }}</p>

                <div class="cooperation-contact-links">
                    <a href="mailto:info@ianubih.ba">
                        <i class="fa fa-envelope-o" aria-hidden="true"></i>
                        <span><small>{{ __('cooperation.contact.email_label') }}</small>info@ianubih.ba</span>
                    </a>
                    <a href="tel:+38761914913">
                        <i class="fa fa-phone" aria-hidden="true"></i>
                        <span><small>{{ __('cooperation.contact.phone_label') }}</small>+387 61 914 913</span>
                    </a>
                </div>

                <div class="cooperation-proposal-note">
                    <h3>{{ __('cooperation.contact.note_title') }}</h3>
                    <ul>
                        @foreach(__('cooperation.contact.note_items') as $item)
                            <li><i class="fa fa-check" aria-hidden="true"></i>{{ $item }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <div class="cooperation-form-panel wow fadeInUp" data-wow-delay="0.15s">
                <span class="section-eyebrow">{{ __('cooperation.form.eyebrow') }}</span>
                <h2 id="cooperation-form-title">{{ __('cooperation.form.title') }}</h2>
                <p>{{ __('cooperation.form.intro') }}</p>

                @if(session('cooperation_success'))
                    <div class="cooperation-form-alert cooperation-form-alert-success" role="status">
                        <i class="fa fa-check-circle" aria-hidden="true"></i>
                        <span>{{ session('cooperation_success') }}</span>
                    </div>
                @endif

                @if(session('cooperation_error'))
                    <div class="cooperation-form-alert cooperation-form-alert-error" role="alert">
                        <i class="fa fa-exclamation-circle" aria-hidden="true"></i>
                        <span>{{ session('cooperation_error') }} <a href="mailto:info@ianubih.ba">info@ianubih.ba</a></span>
                    </div>
                @endif

                @if($errors->any())
                    <div class="cooperation-form-alert cooperation-form-alert-error" role="alert">
                        <i class="fa fa-exclamation-circle" aria-hidden="true"></i>
                        <div>
                            <strong>{{ __('cooperation.form.validation_summary') }}</strong>
                            <ul>
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif

                <form action="{{ route('cooperation.inquiry', ['locale' => app()->getLocale()]) }}" method="POST" class="cooperation-form">
                    @csrf

                    <div class="cooperation-honeypot" aria-hidden="true">
                        <label for="website">Website</label>
                        <input type="text" id="website" name="website" tabindex="-1" autocomplete="off">
                    </div>

                    <div class="cooperation-form-row">
                        <div class="cooperation-field">
                            <label for="name">{{ __('cooperation.form.name') }} <span aria-hidden="true">*</span></label>
                            <input type="text" id="name" name="name" value="{{ old('name') }}" maxlength="120" autocomplete="name" required>
                        </div>
                        <div class="cooperation-field">
                            <label for="email">{{ __('cooperation.form.email') }} <span aria-hidden="true">*</span></label>
                            <input type="email" id="email" name="email" value="{{ old('email') }}" maxlength="190" autocomplete="email" required>
                        </div>
                    </div>

                    <div class="cooperation-form-row">
                        <div class="cooperation-field">
                            <label for="organization">{{ __('cooperation.form.organization') }}</label>
                            <input type="text" id="organization" name="organization" value="{{ old('organization') }}" maxlength="190" autocomplete="organization">
                        </div>
                        <div class="cooperation-field">
                            <label for="partner_type">{{ __('cooperation.form.partner_type') }} <span aria-hidden="true">*</span></label>
                            <select id="partner_type" name="partner_type" required>
                                <option value="">{{ __('cooperation.form.partner_type_placeholder') }}</option>
                                @foreach(__('cooperation.form.partner_types') as $value => $label)
                                    <option value="{{ $value }}" @selected(old('partner_type') === $value)>{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="cooperation-field">
                        <label for="initiative_title">{{ __('cooperation.form.initiative_title') }} <span aria-hidden="true">*</span></label>
                        <input type="text" id="initiative_title" name="initiative_title" value="{{ old('initiative_title') }}" maxlength="190" placeholder="{{ __('cooperation.form.initiative_placeholder') }}" required>
                    </div>

                    <div class="cooperation-field">
                        <label for="message">{{ __('cooperation.form.message') }} <span aria-hidden="true">*</span></label>
                        <textarea id="message" name="message" rows="7" minlength="30" maxlength="5000" placeholder="{{ __('cooperation.form.message_placeholder') }}" required>{{ old('message') }}</textarea>
                    </div>

                    <label class="cooperation-consent" for="consent">
                        <input type="checkbox" id="consent" name="consent" value="1" @checked(old('consent')) required>
                        <span>{{ __('cooperation.form.consent') }}</span>
                    </label>

                    <button type="submit" class="btn btn-ianubih-primary">{{ __('cooperation.form.submit') }}</button>
                    <small class="cooperation-required-note">{{ __('cooperation.form.required_note') }}</small>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection
