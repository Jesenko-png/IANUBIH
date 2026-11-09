@extends('layouts.admin')
@section('title', __('organization_cms.title'))

@php
    $isOverview = $topic === 'overview' && $item === null;
    $isPresidency = $topic === 'presidency' && $item === null;
    $pageTitle = $contents[app()->getLocale()]['title'] ?? $contents['bs']['title'];
    $publicUrl = $isOverview
        ? route('organization', ['locale' => app()->getLocale()])
        : route('organization.topic', array_filter(['locale' => app()->getLocale(), 'topic' => $topic, 'item' => $item]));
    $groups = $isPresidency
        ? collect([
            'profile' => collect($fields)->only(['title', 'role', 'name', 'position', 'image_alt']),
            'facts' => collect($fields)->only(['field', 'institution', 'country']),
            'biography' => collect($fields)->only(['bio']),
        ])
        : collect(['content' => collect($fields)]);
@endphp

@section('content')
<div class="admin-page-heading admin-page-heading-compact academy-editor-heading">
    <div>
        <a class="admin-back-link" href="{{ route('admin.organization.index') }}">{{ __('organization_cms.back') }}</a>
        <span class="admin-eyebrow">{{ __('organization_cms.visual_editor') }}</span>
        <h1>{{ $pageTitle }}</h1>
        <p>{{ __('organization_cms.visual_help') }}</p>
    </div>
    <a class="admin-button admin-button-secondary" href="{{ $publicUrl }}" target="_blank" rel="noopener">{{ __('organization_cms.view') }}</a>
</div>

<form method="POST" action="{{ route('admin.organization.update', array_filter(compact('topic', 'item'))) }}" enctype="multipart/form-data" class="admin-form academy-page-editor">
    @csrf
    @method('PUT')

    <div class="academy-editor-toolbar" role="group" aria-label="{{ __('organization_cms.language_view') }}">
        <span>{{ __('organization_cms.language_view') }}</span>
        <button type="button" class="academy-language-button active" data-organization-language-button="bs" aria-pressed="true">BS <small>Bosanski</small></button>
        <button type="button" class="academy-language-button" data-organization-language-button="en" aria-pressed="false">EN <small>English</small></button>
    </div>

    <div class="academy-editor-layout academy-editor-layout-simple">
        <div class="academy-editor-canvas">
            @if ($isPresidency)
                <section class="academy-visual-section organization-photo-editor">
                    <header class="academy-visual-section-heading">
                        <span><i class="fa fa-camera" aria-hidden="true"></i></span>
                        <div><small>{{ __('organization_cms.shared_content') }}</small><h2>{{ __('organization_cms.photo') }}</h2></div>
                    </header>
                    <div class="organization-photo-grid">
                        @if ($imagePath)
                            <img src="{{ Storage::disk('public')->url($imagePath) }}" alt="">
                        @else
                            <div class="organization-photo-placeholder">{{ __('organization_cms.no_photo') }}</div>
                        @endif
                        <div>
                            <div class="form-field">
                                <label for="photo">{{ __('organization_cms.new_photo') }}</label>
                                <input id="photo" type="file" name="photo" accept="image/jpeg,image/png,image/webp">
                                <small class="field-help">{{ __('organization_cms.photo_help') }}</small>
                            </div>
                            @if ($imagePath)
                                <label class="checkbox-field"><input type="checkbox" name="remove_photo" value="1"> {{ __('organization_cms.remove_photo') }}</label>
                            @endif
                        </div>
                    </div>
                </section>
            @endif

            @foreach (['bs', 'en'] as $language)
                <div class="academy-language-page {{ $language === 'bs' ? 'active' : '' }}" data-organization-language-page="{{ $language }}" @if($language !== 'bs') hidden @endif>
                    <div class="academy-page-browser">
                        <span></span><span></span><span></span>
                        <strong>iasabih.ba/{{ $language }}/organization{{ $isOverview ? '' : '/'.$topic.($item ? '/'.$item : '') }}</strong>
                    </div>

                    @foreach ($groups as $group => $groupFields)
                        <section class="academy-visual-section {{ $group === 'profile' ? 'academy-visual-section-hero' : '' }}">
                            <header class="academy-visual-section-heading">
                                <span>{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
                                <div><small>{{ __('organization_cms.section') }}</small><h2>{{ __('organization_cms.fields.'.$group) }}</h2></div>
                            </header>
                            <div class="academy-section-fields">
                                @foreach ($groupFields as $key => $default)
                                    @php
                                        $field = str_replace('.', '__', $key);
                                        $isLong = in_array($key, ['body', 'bio', 'position'], true);
                                    @endphp
                                    <div class="form-field academy-page-field {{ $isLong ? 'academy-page-field-long' : '' }}">
                                        <label for="organization_{{ $language }}_{{ $field }}">{{ __('organization_cms.fields.'.$key) }}</label>
                                        @if ($isLong)
                                            <textarea id="organization_{{ $language }}_{{ $field }}" name="content[{{ $language }}][{{ $field }}]" rows="{{ in_array($key, ['body', 'bio']) ? 12 : 4 }}" maxlength="50000">{{ old('content.'.$language.'.'.$field, $contents[$language][$key] ?? '') }}</textarea>
                                        @else
                                            <input id="organization_{{ $language }}_{{ $field }}" name="content[{{ $language }}][{{ $field }}]" value="{{ old('content.'.$language.'.'.$field, $contents[$language][$key] ?? '') }}" maxlength="50000">
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
        <div><strong>{{ __('organization_cms.ready_to_save') }}</strong><span>{{ __('organization_cms.save_hint') }}</span></div>
        <button type="submit" class="admin-button admin-button-primary">{{ __('organization_cms.save') }}</button>
    </div>
</form>
@endsection

@push('scripts')
<script>
document.querySelectorAll('[data-organization-language-button]').forEach(function (button) {
    button.addEventListener('click', function () {
        var language = button.dataset.organizationLanguageButton;
        document.querySelectorAll('[data-organization-language-button]').forEach(function (item) {
            var active = item === button;
            item.classList.toggle('active', active);
            item.setAttribute('aria-pressed', active ? 'true' : 'false');
        });
        document.querySelectorAll('[data-organization-language-page]').forEach(function (page) {
            var active = page.dataset.organizationLanguagePage === language;
            page.classList.toggle('active', active);
            page.hidden = !active;
        });
    });
});
</script>
@endpush
