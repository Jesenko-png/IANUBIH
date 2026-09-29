@extends('layouts.app')

@php($legalPage = __('legal.' . $document))

@section('title', $legalPage['meta']['title'])
@section('description', $legalPage['meta']['description'])

@section('content')
<section class="inner-hero legal-hero" aria-labelledby="page-title">
    <div class="inner-hero-shade"></div>
    <div class="container inner-hero-content">
        <div class="row">
            <div class="col-md-9">
                <span class="section-eyebrow section-eyebrow-light">{{ __('legal.common.eyebrow') }}</span>
                <h1 id="page-title">{{ $legalPage['title'] }}</h1>
                <p>{{ $legalPage['intro'] }}</p>
                <nav class="breadcrumbs" aria-label="Breadcrumb">
                    <a href="{{ route('home', ['locale' => app()->getLocale()]) }}">{{ __('legal.common.home') }}</a>
                    <span aria-hidden="true">/</span>
                    <span aria-current="page">{{ $legalPage['title'] }}</span>
                </nav>
            </div>
        </div>
    </div>
</section>

<section class="ianubih-section legal-section">
    <div class="container">
        <div class="legal-layout">
            <aside class="legal-summary" aria-label="{{ __('legal.common.document_information') }}">
                <span>{{ __('legal.common.updated_label') }}</span>
                <strong>{{ __('legal.common.updated_date') }}</strong>
                <p>{{ __('legal.common.contact_note') }}</p>
                <a href="mailto:info@ianubih.ba">info@ianubih.ba</a>
            </aside>

            <div class="legal-document">
                @foreach ($legalPage['sections'] as $section)
                    <section class="legal-block" aria-labelledby="legal-section-{{ $loop->iteration }}">
                        <h2 id="legal-section-{{ $loop->iteration }}">{{ $section['title'] }}</h2>

                        @foreach ($section['paragraphs'] ?? [] as $paragraph)
                            <p>{{ $paragraph }}</p>
                        @endforeach

                        @if (! empty($section['items']))
                            <ul>
                                @foreach ($section['items'] as $item)
                                    <li>{{ $item }}</li>
                                @endforeach
                            </ul>
                        @endif

                        @if (! empty($section['table']))
                            <div class="legal-table-wrap">
                                <table>
                                    <thead>
                                        <tr>
                                            @foreach ($section['table']['headings'] as $heading)
                                                <th scope="col">{{ $heading }}</th>
                                            @endforeach
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($section['table']['rows'] as $row)
                                            <tr>
                                                @foreach ($row as $cell)
                                                    <td>{{ $cell }}</td>
                                                @endforeach
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif

                        @if (($section['show_cookie_settings'] ?? false) === true)
                            <button type="button" class="legal-cookie-button" data-open-cookie-settings>
                                {{ __('legal.common.cookie_settings') }}
                            </button>
                        @endif
                    </section>
                @endforeach

                <div class="legal-contact-card">
                    <span class="section-eyebrow">{{ __('legal.common.contact_eyebrow') }}</span>
                    <h2>{{ __('legal.common.contact_title') }}</h2>
                    <p>{{ __('legal.common.contact_text') }}</p>
                    <a href="mailto:info@ianubih.ba" class="btn btn-ianubih-primary">info@ianubih.ba</a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
    document.querySelectorAll('[data-open-cookie-settings]').forEach(function (button) {
        button.addEventListener('click', function () {
            var settingsButton = document.querySelector('.ianubih-cookie-settings');

            if (settingsButton) {
                settingsButton.click();
            }
        });
    });
</script>
@endpush
