@php($project = $project ?? null)

<div class="editor-grid">
    <div class="editor-main">
        @foreach (['bs', 'en'] as $language)
            @php($meta = old('meta_'.$language, $project?->{'meta_'.$language} ?? []))
            <section class="admin-panel editor-panel">
                <div class="editor-panel-heading">
                    <span>{{ strtoupper($language) }}</span>
                    <div><h2>{{ __('projects_cms.'.$language.'_content') }}</h2><p>{{ __('projects_cms.language_intro') }}</p></div>
                </div>
                <div class="form-field">
                    <label for="title_{{ $language }}">{{ __('projects_cms.project_title') }}</label>
                    <input id="title_{{ $language }}" name="title_{{ $language }}" value="{{ old('title_'.$language, $project?->{'title_'.$language}) }}" maxlength="255" required>
                </div>
                <div class="form-field">
                    <label for="kind_{{ $language }}">{{ __('projects_cms.kind') }}</label>
                    <input id="kind_{{ $language }}" name="kind_{{ $language }}" value="{{ old('kind_'.$language, $project?->{'kind_'.$language}) }}" maxlength="160" required>
                </div>
                <div class="form-field">
                    <label for="programme_{{ $language }}">{{ __('projects_cms.programme') }}</label>
                    <input id="programme_{{ $language }}" name="programme_{{ $language }}" value="{{ old('programme_'.$language, $project?->{'programme_'.$language}) }}" maxlength="160" placeholder="ERASMUS+" required>
                </div>
                <div class="form-field">
                    <label for="summary_{{ $language }}">{{ __('projects_cms.summary') }}</label>
                    <textarea id="summary_{{ $language }}" name="summary_{{ $language }}" rows="7" maxlength="2000" required>{{ old('summary_'.$language, $project?->{'summary_'.$language}) }}</textarea>
                </div>

                <h3 class="project-meta-heading">{{ __('projects_cms.details') }}</h3>
                <p class="field-help">{{ __('projects_cms.details_help') }}</p>
                <div class="project-meta-editor">
                    @for ($index = 0; $index < 4; $index++)
                        <div class="project-meta-row">
                            <div class="form-field">
                                <label for="meta_{{ $language }}_{{ $index }}_label">{{ __('projects_cms.detail_label', ['number' => $index + 1]) }}</label>
                                <input id="meta_{{ $language }}_{{ $index }}_label" name="meta_{{ $language }}[{{ $index }}][label]" value="{{ data_get($meta, $index.'.label') }}" maxlength="120">
                            </div>
                            <div class="form-field">
                                <label for="meta_{{ $language }}_{{ $index }}_value">{{ __('projects_cms.detail_value') }}</label>
                                <input id="meta_{{ $language }}_{{ $index }}_value" name="meta_{{ $language }}[{{ $index }}][value]" value="{{ data_get($meta, $index.'.value') }}" maxlength="500">
                            </div>
                        </div>
                    @endfor
                </div>
            </section>
        @endforeach
    </div>

    <aside class="editor-sidebar">
        <section class="admin-panel editor-panel editor-panel-sticky">
            <h2>{{ __('projects_cms.publication') }}</h2>
            <div class="form-field">
                <label for="project_status">{{ __('projects_cms.project_status') }}</label>
                <select id="project_status" name="project_status" required>
                    <option value="active" @selected(old('project_status', $project?->project_status ?? 'active') === 'active')>{{ __('projects_cms.active') }}</option>
                    <option value="completed" @selected(old('project_status', $project?->project_status) === 'completed')>{{ __('projects_cms.completed') }}</option>
                </select>
            </div>
            <div class="form-field">
                <label for="status">{{ __('projects_cms.visibility') }}</label>
                <select id="status" name="status" required>
                    <option value="draft" @selected(old('status', $project?->status ?? 'draft') === 'draft')>{{ __('projects_cms.draft') }}</option>
                    <option value="published" @selected(old('status', $project?->status) === 'published')>{{ __('projects_cms.published') }}</option>
                </select>
            </div>
            <div class="form-field">
                <label for="sort_order">{{ __('projects_cms.sort_order') }}</label>
                <input id="sort_order" type="number" name="sort_order" min="0" max="9999" value="{{ old('sort_order', $project?->sort_order ?? 0) }}">
                <small class="field-help">{{ __('projects_cms.sort_order_help') }}</small>
            </div>
            <div class="editor-actions">
                <button type="submit" class="admin-button admin-button-primary">{{ __('projects_cms.save') }}</button>
                <a href="{{ route('admin.projects.index') }}" class="admin-button admin-button-secondary">{{ __('projects_cms.cancel') }}</a>
            </div>
        </section>
    </aside>
</div>
