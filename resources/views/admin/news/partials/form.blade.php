@php($post = $post ?? null)

<div class="editor-grid">
    <div class="editor-main">
        <section class="admin-panel editor-panel">
            <div class="editor-panel-heading">
                <span>BS</span>
                <div><h2>Bosanski sadržaj</h2><p>Primarna verzija vijesti.</p></div>
            </div>
            <div class="form-field">
                <label for="title_bs">Naslov</label>
                <input id="title_bs" name="title_bs" value="{{ old('title_bs', $post?->title_bs) }}" maxlength="255" required>
            </div>
            <div class="form-field">
                <label for="category_bs">Kategorija</label>
                <input id="category_bs" name="category_bs" value="{{ old('category_bs', $post?->category_bs) }}" maxlength="100" placeholder="Npr. Saopćenje" required>
            </div>
            <div class="form-field">
                <label for="excerpt_bs">Sažetak <small>do 600 znakova</small></label>
                <textarea id="excerpt_bs" name="excerpt_bs" rows="4" maxlength="600" required>{{ old('excerpt_bs', $post?->excerpt_bs) }}</textarea>
            </div>
            <div class="form-field">
                <label for="body_bs">Puni sadržaj</label>
                <textarea id="body_bs" name="body_bs" rows="16" required>{{ old('body_bs', $post?->body_bs) }}</textarea>
                <small class="field-help">Odvojite pasuse praznim redom. HTML kod se ne izvršava.</small>
            </div>
        </section>

        <section class="admin-panel editor-panel">
            <div class="editor-panel-heading">
                <span>EN</span>
                <div><h2>English content</h2><p>English version of the same news item.</p></div>
            </div>
            <div class="form-field">
                <label for="title_en">Title</label>
                <input id="title_en" name="title_en" value="{{ old('title_en', $post?->title_en) }}" maxlength="255" required>
            </div>
            <div class="form-field">
                <label for="category_en">Category</label>
                <input id="category_en" name="category_en" value="{{ old('category_en', $post?->category_en) }}" maxlength="100" placeholder="E.g. Announcement" required>
            </div>
            <div class="form-field">
                <label for="excerpt_en">Summary <small>up to 600 characters</small></label>
                <textarea id="excerpt_en" name="excerpt_en" rows="4" maxlength="600" required>{{ old('excerpt_en', $post?->excerpt_en) }}</textarea>
            </div>
            <div class="form-field">
                <label for="body_en">Full content</label>
                <textarea id="body_en" name="body_en" rows="16" required>{{ old('body_en', $post?->body_en) }}</textarea>
            </div>
        </section>
    </div>

    <aside class="editor-sidebar">
        <section class="admin-panel editor-panel editor-panel-sticky">
            <h2>Objava</h2>
            <div class="form-field">
                <label for="status">Status</label>
                <select id="status" name="status" required>
                    <option value="draft" @selected(old('status', $post?->status ?? 'draft') === 'draft')>Nacrt</option>
                    <option value="published" @selected(old('status', $post?->status) === 'published')>Objavljeno</option>
                </select>
            </div>
            <div class="form-field">
                <label for="published_at">Datum i vrijeme objave</label>
                <input id="published_at" type="datetime-local" name="published_at" value="{{ old('published_at', $post?->published_at?->format('Y-m-d\TH:i')) }}">
                <small class="field-help">Ako ostane prazno pri objavi, koristi se trenutno vrijeme. Budući datum zakazuje objavu.</small>
            </div>

            <hr>

            <h2>Naslovna slika</h2>
            @if ($post?->image_path)
                <img class="current-cover" src="{{ Storage::url($post->image_path) }}" alt="Trenutna naslovna slika">
            @endif
            <div class="form-field">
                <label for="image">{{ $post ? 'Zamijeni sliku' : 'Odaberi sliku' }}</label>
                <input id="image" type="file" name="image" accept="image/jpeg,image/png,image/webp" @required(! $post)>
                <small class="field-help">JPG, PNG ili WebP; najmanje 600 × 350 px; najviše 5 MB.</small>
            </div>
            <div class="form-field">
                <label for="image_alt_bs">Opis slike — BS</label>
                <input id="image_alt_bs" name="image_alt_bs" value="{{ old('image_alt_bs', $post?->image_alt_bs) }}" maxlength="255">
            </div>
            <div class="form-field">
                <label for="image_alt_en">Image description — EN</label>
                <input id="image_alt_en" name="image_alt_en" value="{{ old('image_alt_en', $post?->image_alt_en) }}" maxlength="255">
            </div>

            <div class="editor-actions">
                <button type="submit" class="admin-button admin-button-primary">Sačuvaj vijest</button>
                <a href="{{ route('admin.news.index') }}" class="admin-button admin-button-secondary">Odustani</a>
            </div>
        </section>
    </aside>
</div>
