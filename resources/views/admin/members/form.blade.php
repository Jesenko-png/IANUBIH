@php($member = $member ?? null)

<div class="editor-grid">
    <div class="editor-main">
        <section class="admin-panel editor-panel">
            <h2>{{ __('members.admin.identity') }}</h2>
            <div class="form-field">
                <label for="name">{{ __('members.admin.name') }}</label>
                <input id="name" name="name" value="{{ old('name', $member?->name) }}" maxlength="160" required>
            </div>
            <div class="form-field">
                <label for="academic_title">{{ __('members.admin.academic_title') }}</label>
                <input id="academic_title" name="academic_title" value="{{ old('academic_title', $member?->academic_title) }}" maxlength="120">
                <small class="field-help">{{ __('members.admin.academic_title_help') }}</small>
            </div>
        </section>

        @foreach (['bs', 'en'] as $language)
            <section class="admin-panel editor-panel">
                <div class="editor-panel-heading">
                    <span>{{ strtoupper($language) }}</span>
                    <div><h2>{{ __('members.admin.'.$language.'_content') }}</h2></div>
                </div>
                <div class="form-field">
                    <label for="category_{{ $language }}">{{ __('members.admin.category_'.$language) }}</label>
                    <input id="category_{{ $language }}" name="category_{{ $language }}" value="{{ old('category_'.$language, $member?->{'category_'.$language}) }}" maxlength="160">
                    <small class="field-help">{{ __('members.admin.category_help') }}</small>
                </div>
                <div class="form-field">
                    <label for="position_{{ $language }}">{{ __('members.admin.position_'.$language) }}</label>
                    <input id="position_{{ $language }}" name="position_{{ $language }}" value="{{ old('position_'.$language, $member?->{'position_'.$language}) }}" maxlength="160">
                </div>
                <div class="form-field">
                    <label for="field_{{ $language }}">{{ __('members.admin.field_'.$language) }}</label>
                    <input id="field_{{ $language }}" name="field_{{ $language }}" value="{{ old('field_'.$language, $member?->{'field_'.$language}) }}" maxlength="180" required>
                </div>
                <div class="form-field">
                    <label for="institution_{{ $language }}">{{ __('members.admin.institution_'.$language) }}</label>
                    <input id="institution_{{ $language }}" name="institution_{{ $language }}" value="{{ old('institution_'.$language, $member?->{'institution_'.$language}) }}" maxlength="180">
                </div>
                <div class="form-field">
                    <label for="country_{{ $language }}">{{ __('members.admin.country_'.$language) }}</label>
                    <input id="country_{{ $language }}" name="country_{{ $language }}" value="{{ old('country_'.$language, $member?->{'country_'.$language}) }}" maxlength="100">
                </div>
                <div class="form-field">
                    <label for="bio_{{ $language }}">{{ __('members.admin.bio_'.$language) }}</label>
                    <textarea id="bio_{{ $language }}" name="bio_{{ $language }}" rows="8" maxlength="5000">{{ old('bio_'.$language, $member?->{'bio_'.$language}) }}</textarea>
                </div>
            </section>
        @endforeach

        <section class="admin-panel editor-panel">
            <h2>{{ __('members.admin.contact') }}</h2>
            <p class="field-help">{{ __('members.admin.contact_help') }}</p>
            <div class="form-field">
                <label for="email">{{ __('members.admin.email') }}</label>
                <input id="email" type="email" name="email" value="{{ old('email', $member?->email) }}" maxlength="190">
            </div>
            <div class="form-field">
                <label for="website_url">{{ __('members.admin.website_url') }}</label>
                <input id="website_url" type="url" name="website_url" value="{{ old('website_url', $member?->website_url) }}" maxlength="500" placeholder="https://">
            </div>
        </section>
    </div>

    <aside class="editor-sidebar">
        <section class="admin-panel editor-panel editor-panel-sticky">
            <h2>{{ __('members.admin.publication') }}</h2>
            <div class="form-field">
                <label for="status">{{ __('members.admin.status') }}</label>
                <select id="status" name="status" required>
                    <option value="draft" @selected(old('status', $member?->status ?? 'draft') === 'draft')>{{ __('members.admin.draft') }}</option>
                    <option value="published" @selected(old('status', $member?->status) === 'published')>{{ __('members.admin.published') }}</option>
                </select>
            </div>
            <div class="form-field">
                <label for="sort_order">{{ __('members.admin.sort_order') }}</label>
                <input id="sort_order" type="number" name="sort_order" min="0" max="9999" value="{{ old('sort_order', $member?->sort_order ?? 0) }}">
                <small class="field-help">{{ __('members.admin.sort_order_help') }}</small>
            </div>
            <hr>
            <h2>{{ __('members.admin.photo') }}</h2>
            @if ($member?->photo_path)
                <img class="current-cover admin-member-current-photo" src="{{ Storage::disk('public')->url($member->photo_path) }}" alt="{{ $member->name }}">
                <label class="checkbox-field"><input type="checkbox" name="remove_photo" value="1" @checked(old('remove_photo'))> {{ __('members.admin.remove_photo') }}</label>
            @endif
            <div class="form-field">
                <label for="photo">{{ $member?->photo_path ? __('members.admin.replace_photo') : __('members.admin.photo') }}</label>
                <input id="photo" type="file" name="photo" accept="image/jpeg,image/png,image/webp">
                <small class="field-help">{{ __('members.admin.photo_help') }}</small>
            </div>
            <div class="editor-actions">
                <button type="submit" class="admin-button admin-button-primary">{{ __('members.admin.save') }}</button>
                <a href="{{ route('admin.members.index') }}" class="admin-button admin-button-secondary">{{ __('members.admin.cancel') }}</a>
            </div>
        </section>
    </aside>
</div>
