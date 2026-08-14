@php($post = $post ?? null)

<div class="editor-grid">
    <div class="editor-main">
        <section class="admin-panel editor-panel">
            <div class="editor-panel-heading">
                <span>BS</span>
                <div><h2>{{ __('admin.news.bs_content_title') }}</h2><p>{{ __('admin.news.bs_content_intro') }}</p></div>
            </div>
            <div class="form-field">
                <label for="title_bs">{{ __('admin.news.title_bs') }}</label>
                <input id="title_bs" name="title_bs" value="{{ old('title_bs', $post?->title_bs) }}" maxlength="255" required>
            </div>
            <div class="form-field">
                <label for="category_bs">{{ __('admin.news.category_bs') }}</label>
                <input id="category_bs" name="category_bs" value="{{ old('category_bs', $post?->category_bs) }}" maxlength="100" placeholder="{{ __('admin.news.category_bs_placeholder') }}" required>
            </div>
            <div class="form-field">
                <label for="excerpt_bs">{{ __('admin.news.excerpt_bs') }} <small>{{ __('admin.news.excerpt_limit') }}</small></label>
                <textarea id="excerpt_bs" name="excerpt_bs" rows="4" maxlength="600" required>{{ old('excerpt_bs', $post?->excerpt_bs) }}</textarea>
            </div>
            <div class="form-field">
                <label for="body_bs">{{ __('admin.news.body_bs') }}</label>
                <textarea id="body_bs" name="body_bs" rows="16" required>{{ old('body_bs', $post?->body_bs) }}</textarea>
                <small class="field-help">{{ __('admin.news.body_bs_help') }}</small>
            </div>
        </section>

        <section class="admin-panel editor-panel">
            <div class="editor-panel-heading">
                <span>EN</span>
                <div><h2>{{ __('admin.news.en_content_title') }}</h2><p>{{ __('admin.news.en_content_intro') }}</p></div>
            </div>
            <div class="form-field">
                <label for="title_en">{{ __('admin.news.title_en') }}</label>
                <input id="title_en" name="title_en" value="{{ old('title_en', $post?->title_en) }}" maxlength="255" required>
            </div>
            <div class="form-field">
                <label for="category_en">{{ __('admin.news.category_en') }}</label>
                <input id="category_en" name="category_en" value="{{ old('category_en', $post?->category_en) }}" maxlength="100" placeholder="{{ __('admin.news.category_en_placeholder') }}" required>
            </div>
            <div class="form-field">
                <label for="excerpt_en">{{ __('admin.news.excerpt_en') }} <small>{{ __('admin.news.excerpt_limit') }}</small></label>
                <textarea id="excerpt_en" name="excerpt_en" rows="4" maxlength="600" required>{{ old('excerpt_en', $post?->excerpt_en) }}</textarea>
            </div>
            <div class="form-field">
                <label for="body_en">{{ __('admin.news.body_en') }}</label>
                <textarea id="body_en" name="body_en" rows="16" required>{{ old('body_en', $post?->body_en) }}</textarea>
            </div>
        </section>
    </div>

    <aside class="editor-sidebar">
        <section class="admin-panel editor-panel editor-panel-sticky">
            <h2>{{ __('admin.news.publication') }}</h2>
            <div class="form-field">
                <label for="status">{{ __('admin.news.status') }}</label>
                <select id="status" name="status" required>
                    <option value="draft" @selected(old('status', $post?->status ?? 'draft') === 'draft')>{{ __('admin.news.draft') }}</option>
                    <option value="published" @selected(old('status', $post?->status) === 'published')>{{ __('admin.news.published') }}</option>
                </select>
            </div>
            <div class="form-field">
                <label for="published_at">{{ __('admin.news.published_at') }}</label>
                <input id="published_at" type="datetime-local" name="published_at" value="{{ old('published_at', $post?->published_at?->format('Y-m-d\TH:i')) }}">
                <small class="field-help">{{ __('admin.news.published_at_help') }}</small>
            </div>

            <hr>

            <h2>{{ __('admin.news.cover_image') }}</h2>
            @if ($post?->image_path)
                <img class="current-cover" src="{{ Storage::url($post->image_path) }}" alt="{{ __('admin.news.current_cover_alt') }}">
            @endif
            <div class="form-field">
                <label for="image">{{ $post ? __('admin.news.replace_image') : __('admin.news.select_image') }}</label>
                <input id="image" type="file" name="image" accept="image/jpeg,image/png,image/webp" @required(! $post)>
                <small class="field-help">{{ __('admin.news.image_help') }}</small>
            </div>
            <div class="form-field">
                <label for="image_alt_bs">{{ __('admin.news.image_alt_bs') }}</label>
                <input id="image_alt_bs" name="image_alt_bs" value="{{ old('image_alt_bs', $post?->image_alt_bs) }}" maxlength="255">
            </div>
            <div class="form-field">
                <label for="image_alt_en">{{ __('admin.news.image_alt_en') }}</label>
                <input id="image_alt_en" name="image_alt_en" value="{{ old('image_alt_en', $post?->image_alt_en) }}" maxlength="255">
            </div>

            <div class="editor-actions">
                <button type="submit" class="admin-button admin-button-primary">{{ __('admin.news.save') }}</button>
                <a href="{{ route('admin.news.index') }}" class="admin-button admin-button-secondary">{{ __('admin.news.cancel') }}</a>
            </div>
        </section>
    </aside>
</div>
