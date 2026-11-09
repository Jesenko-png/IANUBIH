@extends('layouts.admin')
@section('title', __('academy_cms.title'))

@php
    $pageTitle = $page === 'about' ? __('academy_cms.overview') : __('sections.pages.academy.'.$page.'.title');
    $publicUrl = $page === 'about'
        ? route('about', ['locale' => app()->getLocale()])
        : route('academy.topic', ['locale' => app()->getLocale(), 'topic' => $page]);
    $groups = collect($fields)->groupBy(
        fn ($value, $key) => str_contains($key, '.') ? str($key)->before('.')->toString() : $key,
        preserveKeys: true,
    );
    $sectionOrder = ['meta', 'hero', 'identity', 'mission', 'values', 'president', 'governance', 'documents', 'faq', 'cta', 'additional_title', 'additional_body'];
    $groups = $groups->sortBy(fn ($value, $key) => array_search($key, $sectionOrder, true) === false ? 999 : array_search($key, $sectionOrder, true));
    if ($page !== 'about') {
        $groups = collect(['content' => collect($fields)]);
    }
@endphp

@section('content')
<div class="admin-page-heading admin-page-heading-compact academy-editor-heading">
    <div>
        <a class="admin-back-link" href="{{ route('admin.academy.index') }}">{{ __('academy_cms.back') }}</a>
        <span class="admin-eyebrow">{{ __('academy_cms.visual_editor') }}</span>
        <h1>{{ $pageTitle }}</h1>
        <p>{{ __('academy_cms.visual_help') }}</p>
    </div>
    <a class="admin-button admin-button-secondary" href="{{ $publicUrl }}" target="_blank" rel="noopener">{{ __('academy_cms.view') }}</a>
</div>

<form method="POST" action="{{ route('admin.academy.update', $page) }}" class="admin-form academy-page-editor" data-academy-editor>
    @csrf
    @method('PUT')

    <div class="academy-editor-toolbar" role="group" aria-label="{{ __('academy_cms.language_view') }}">
        <span>{{ __('academy_cms.language_view') }}</span>
        <button type="button" class="academy-language-button active" data-language-button="bs" aria-pressed="true">BS <small>Bosanski</small></button>
        <button type="button" class="academy-language-button" data-language-button="en" aria-pressed="false">EN <small>English</small></button>
    </div>

    <div class="academy-editor-layout {{ $page !== 'about' ? 'academy-editor-layout-simple' : '' }}">
        @if ($page === 'about')
            <aside class="academy-editor-outline" aria-label="{{ __('academy_cms.page_structure') }}">
                <strong>{{ __('academy_cms.page_structure') }}</strong>
                <ol>
                    @foreach ($groups as $group => $groupFields)
                        <li>
                            <a href="#academy-section-bs-{{ $group }}" data-outline-link="{{ $group }}">
                                <span>{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
                                {{ __('academy_cms.fields.'.$group) }}
                            </a>
                        </li>
                    @endforeach
                </ol>
            </aside>
        @endif

        <div class="academy-editor-canvas">
            @foreach (['bs', 'en'] as $language)
                <div class="academy-language-page {{ $language === 'bs' ? 'active' : '' }}" data-language-page="{{ $language }}" @if($language !== 'bs') hidden @endif>
                    <div class="academy-page-browser">
                        <span></span><span></span><span></span>
                        <strong>{{ $language === 'bs' ? 'iasabih.ba/bs' : 'iasabih.ba/en' }}/{{ $page === 'about' ? 'about' : 'academy/'.$page }}</strong>
                    </div>

                    @foreach ($groups as $group => $groupFields)
                        @php
                            $displayGroup = in_array($group, ['additional_title', 'additional_body'], true) ? 'additional' : $group;
                            $sectionNumber = str_pad($loop->iteration, 2, '0', STR_PAD_LEFT);
                        @endphp
                        <section id="academy-section-{{ $language }}-{{ $group }}" class="academy-visual-section academy-visual-section-{{ $displayGroup }}">
                            <header class="academy-visual-section-heading">
                                <span>{{ $sectionNumber }}</span>
                                <div>
                                    <small>{{ __('academy_cms.section') }}</small>
                                    <h2>{{ __('academy_cms.fields.'.$group) }}</h2>
                                </div>
                            </header>

                            <div class="academy-section-fields">
                                @foreach ($groupFields as $key => $default)
                                    @php
                                        $field = str_replace('.', '__', $key);
                                        $relativeKey = str_starts_with($key, $group.'.') ? substr($key, strlen($group) + 1) : $key;
                                        $parts = explode('.', $relativeKey);
                                        $label = collect($parts)->map(fn ($part) => is_numeric($part)
                                            ? __('academy_cms.item_number', ['number' => ((int) $part + 1)])
                                            : (\Illuminate\Support\Facades\Lang::has('academy_cms.fields.'.$part) ? __('academy_cms.fields.'.$part) : str_replace('_', ' ', ucfirst($part))))->implode(' / ');
                                        $isLong = in_array(last($parts), ['text', 'text_first', 'text_second', 'mission_text', 'vision_text', 'answer', 'body', 'additional_body', 'description'], true);
                                    @endphp
                                    <div class="form-field academy-page-field {{ $isLong ? 'academy-page-field-long' : '' }}">
                                        <label for="{{ $language }}_{{ $field }}">{{ $label }}</label>
                                        @if ($isLong)
                                            <textarea id="{{ $language }}_{{ $field }}" name="content[{{ $language }}][{{ $field }}]" rows="{{ in_array($key, ['body', 'additional_body']) ? 12 : 4 }}" maxlength="50000">{{ old('content.'.$language.'.'.$field, $contents[$language][$key] ?? '') }}</textarea>
                                        @else
                                            <input id="{{ $language }}_{{ $field }}" name="content[{{ $language }}][{{ $field }}]" value="{{ old('content.'.$language.'.'.$field, $contents[$language][$key] ?? '') }}" maxlength="50000">
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </section>
                    @endforeach
                </div>
            @endforeach
        </div>
    </div>

    <div class="academy-editor-savebar">
        <div>
            <strong>{{ __('academy_cms.ready_to_save') }}</strong>
            <span>{{ __('academy_cms.save_hint') }}</span>
        </div>
        <button type="submit" class="admin-button admin-button-primary">{{ __('academy_cms.save') }}</button>
    </div>
</form>
@endsection

@push('scripts')
<script>
document.querySelectorAll('[data-language-button]').forEach(function (button) {
    button.addEventListener('click', function () {
        var language = button.dataset.languageButton;
        document.querySelectorAll('[data-language-button]').forEach(function (item) {
            var active = item === button;
            item.classList.toggle('active', active);
            item.setAttribute('aria-pressed', active ? 'true' : 'false');
        });
        document.querySelectorAll('[data-language-page]').forEach(function (page) {
            var active = page.dataset.languagePage === language;
            page.classList.toggle('active', active);
            page.hidden = !active;
        });
        document.querySelectorAll('[data-outline-link]').forEach(function (link) {
            link.href = '#academy-section-' + language + '-' + link.dataset.outlineLink;
        });
    });
});
</script>
@endpush
